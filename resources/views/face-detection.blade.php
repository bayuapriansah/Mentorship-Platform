<!DOCTYPE html>
<html>
<head>
    <title>Deteksi Wajah</title>
    <style>
        #videoElement {
            width: 640px;
            height: 480px;
        }
    </style>
</head>
<body>
    <h1>Deteksi Wajah</h1>
    {{-- <h2>{{ public_path('assets/face.py') }}</h2> --}}
    <video autoplay="true" id="videoElement"></video>

    <button onclick="runFaceDetection()">Run Face Detection</button>

    <script>
        function runFaceDetection() {
            fetch('/run-face-detection')
                .then(response => {
                    if (response.ok) {
                        console.log('Face detection script executed successfully.');
                    } else {
                        console.error('Error running face detection script.');
                    }
                })
                .catch(error => {
                    console.error('Error running face detection script:', error);
                });
        }
    </script>
</body>
</html>