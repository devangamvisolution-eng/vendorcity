<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        {{ __('Welcome, ' . $vendor->name . '! Please upload your signed contract below.') }}
    </div>

    @if (session('success'))
        <div class="mb-4 font-medium text-sm text-green-600">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="mb-4 font-medium text-sm text-red-600">
            {{ session('error') }}
        </div>
    @endif

    @if ($vendor->contract_status == 'contract_uploaded')
        <div class="mb-4 font-medium text-sm text-blue-600">
            Your contract has been uploaded and is pending admin approval. You will receive an email once your account is active.
        </div>
    @elseif ($vendor->contract_status == 'approved')
        <div class="mb-4 font-medium text-sm text-green-600">
            Your contract has already been approved! You can now log into your dashboard.
        </div>
        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('vendor.login') }}">
                {{ __('Go to Login') }}
            </a>
        </div>
    @else
        <form method="POST" action="{{ route('vendor.contract.upload.submit', ['id' => $vendor->id] + request()->query()) }}" enctype="multipart/form-data">
            @csrf
            
            <div class="mb-4 text-sm text-gray-600">
                You can download the unsigned contract <a href="{{ route('contract.download', $vendor->contract_pdf_path) }}" target="_blank" class="underline text-indigo-600">here</a>.
            </div>

            <!-- Upload Field -->
            <div>
                <x-input-label for="signed_contract" :value="__('Signed Contract (PDF)')" />
                <input id="signed_contract" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" type="file" name="signed_contract" required accept=".pdf" style="padding: 10px;" />
                <x-input-error :messages="$errors->get('signed_contract')" class="mt-2" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-primary-button class="ml-3">
                    {{ __('Upload Contract') }}
                </x-primary-button>
            </div>
        </form>
    @endif
</x-guest-layout>
