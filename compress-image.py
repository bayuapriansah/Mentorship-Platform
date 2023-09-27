import os
import png
from PIL import Image
from tqdm import tqdm
from concurrent.futures import ProcessPoolExecutor
import zopfli.zlib

def compress_image(args):
    image_path, output_path, quality, format = args
    if format == 'PNG':
        image = Image.open(image_path)
        width, height = image.size
        image_data = list(image.getdata())
        compressed_data = png.Writer(width, height, greyscale=False, alpha=True, compression=zopfli.zlib.ZOPFLI_ZLIB_COMPRESSOR)
        with open(output_path, 'wb') as f:
            compressed_data.write(f, image_data)
    else:
        image = Image.open(image_path)
        image.save(output_path, format=format, quality=quality, optimize=True)
    return image_path, output_path, os.path.getsize(output_path)

def compress_images_in_folder(folder_path, target_size=500 * 1024):
    supported_formats = ('.jpg', '.jpeg', '.png', '.bmp', '.gif')
    tasks = []

    for root, _, files in os.walk(folder_path):
        for file in files:
            file_ext = os.path.splitext(file)[1].lower()
            if file_ext not in supported_formats:
                continue

            file_path = os.path.join(root, file)
            file_size = os.path.getsize(file_path)

            if file_size > 1 * 1024 * 1024:  # Check if the file size is greater than 1 MB
                output_path = os.path.join(root, f"{file}")
                quality = 75
                format = 'JPEG' if file_ext in ('.jpg', '.jpeg') else 'PNG'
                tasks.append((file_path, output_path, quality, format))

    with ProcessPoolExecutor() as executor:
        with tqdm(total=len(tasks), desc="Compressing images", unit="image", ncols=100, bar_format="{l_bar}{bar}| {n_fmt}/{total_fmt} [{rate_fmt}{postfix}]") as progress_bar:
            for file_path, output_path, compressed_size in executor.map(compress_image, tasks):
                if compressed_size <= target_size:
                    os.remove(file_path)
                    os.rename(output_path, file_path)
                    print(f"Compressed: {file_path} (Original size: {os.path.getsize(file_path)} bytes, Compressed size: {compressed_size} bytes)")
                progress_bar.update(1)

folder_path = "/var/www/html/stagingsip/storage/app/public/companies"
compress_images_in_folder(folder_path)
# folder_path = "/var/www/html/stagingsip/public/assets/img"
