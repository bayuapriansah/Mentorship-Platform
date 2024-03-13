<div>
    <div id="message-form" class="border border-light-blue p-6 rounded-xl bg-white space-y-2">
        <p class="border-b-2 text-dark-blue font-medium">
            To:

            <span class="font-light text-black pl-4 capitalize">
                {{ auth('student')->user()->mentor->first_name }} {{ auth('student')->user()->mentor->last_name }} (Supervisor);

                @if ( auth('student')->user()->staff_id )
                    {{ auth('student')->user()->staff->first_name }} {{ auth('student')->user()->staff->last_name }} (Customer)
                @endif
            </span>
        </p>

        <p class="border-b-2 text-dark-blue font-medium capitalize">
            CC:
            <span class="font-light text-black">Admin</span>
        </p>

        <div id="form-chat">
            <div class="w-full mb-4 ">
                <div class="bg-white  rounded-t-lg   ">
                    <textarea id="comment" rows="4" class="w-full px-0 text-sm text-gray-900 bg-white border-0  focus:outline-none" name="message" placeholder="Type Here" required novalidate></textarea>
                </div>
                <div class="flex items-center justify-between bg-white rounded-b-lg">
                    <div class="flex pl-0 space-x-1 sm:pl-2 items-center">
                        <label for="file-chat-input" type="button" class="inline-flex justify-center p-2 text-gray-500 rounded cursor-pointer hover:text-gray-900 ">
                          <img src="{{asset('assets/img/icon/clip.svg')}}" class="w-[10px]" alt="">
                        </label>
                        <div id="chatFileName"></div>
                        <input id="file-chat-input" class="hidden" type="file" name="file" />
                    </div>
                    <div class="mt-2 space-x-3">
                        <button type="button" class="px-6 py-1 bg-white border border-primary rounded-full text-primary text-sm" id="btn-cancel">
                            Cancel
                        </button>

                        <button type="submit" class="px-8 py-1 bg-primary border border-primary rounded-full text-white text-sm" id="btn-cancel">
                            Send
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
