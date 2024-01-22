<div {{ $attributes->merge(['class' => 'flex justify-between items-baseline']) }}>
    <div class="w-max flex flex-col items-center">
        <div class="w-6 h-6 bg-[#11BF61] rounded-full flex justify-center items-center">
            <i class="fas fa-calendar-day fa-xs text-white"></i>
        </div>

        <p class="mt-2 text-center text-[10px] font-semibold">
            Start Date
        </p>

        <p class="text-center text-[10px] font-medium">
            {{ $getStartDate() }}
        </p>
    </div>

    <div class="relative flex-1">
        {{ $renderFlags() }}
        <div class="bg-gray-200 rounded-full h-1.5 mt-4 ">
            <div class="bg-[#11BF61] h-1.5 rounded-full" style="width: {{ $getTimeProgress() }}%"></div>
        </div>
        {{ $renderFlagsInfo() }}
    </div>

    <div class="w-max flex flex-col items-center">
        <div class="w-6 h-6 bg-[#11BF61] rounded-full flex justify-center items-center">
            <i class="fas fa-calendar-day fa-xs text-white"></i>
        </div>

        <p class="mt-2 text-center text-[10px] font-semibold">
            End Date
        </p>

        <p class="text-center text-[10px] font-medium">
            {{ $getEndDate() }}
        </p>
    </div>
</div>
