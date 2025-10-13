<div class="p-8">
    <!-- Success Message -->
    @if (session()->has('message'))
        <div class="mb-6 p-4 bg-gradient-to-r from-green-500/20 to-emerald-500/20 border border-green-500/50 rounded-xl text-green-400 animate-fade-in">
            <div class="flex items-center gap-3">
                <i class="ri-checkbox-circle-line text-2xl"></i>
                <span>{{ session('message') }}</span>
            </div>
        </div>
    @endif

    <form wire:submit.prevent="save">
        <!-- Tabs Navigation -->
        <div class="flex gap-2 mb-6 border-b border-[#2a3548] overflow-x-auto" x-data="{ activeTab: 'hero' }">
            <button type="button" @click="activeTab = 'hero'" 
                    class="px-6 py-3 font-medium transition-all duration-300 border-b-2"
                    :class="activeTab === 'hero' ? 'text-primary border-primary' : 'text-gray-400 border-transparent hover:text-white'">
                <i class="ri-image-line ml-2"></i>
                قسم البطل (Hero)
            </button>
            <button type="button" @click="activeTab = 'banner'" 
                    class="px-6 py-3 font-medium transition-all duration-300 border-b-2"
                    :class="activeTab === 'banner' ? 'text-primary border-primary' : 'text-gray-400 border-transparent hover:text-white'">
                <i class="ri-landscape-line ml-2"></i>
                البانر (Banner)
            </button>
            <button type="button" @click="activeTab = 'custom'" 
                    class="px-6 py-3 font-medium transition-all duration-300 border-b-2"
                    :class="activeTab === 'custom' ? 'text-primary border-primary' : 'text-gray-400 border-transparent hover:text-white'">
                <i class="ri-settings-3-line ml-2"></i>
                بيانات مخصصة
            </button>
            <button type="button" @click="activeTab = 'code'" 
                    class="px-6 py-3 font-medium transition-all duration-300 border-b-2"
                    :class="activeTab === 'code' ? 'text-primary border-primary' : 'text-gray-400 border-transparent hover:text-white'">
                <i class="ri-code-line ml-2"></i>
                CSS/JS مخصص
            </button>
        </div>

        <!-- Hero Section Tab -->
        <div x-data="{ activeTab: 'hero' }" x-show="activeTab === 'hero'" class="space-y-6">
            <h3 class="text-xl font-bold text-white mb-4 flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg bg-gradient-to-r from-primary/20 to-secondary/20 flex items-center justify-center">
                    <i class="ri-image-line text-primary"></i>
                </div>
                قسم البطل (Hero Section)
            </h3>

            <!-- Hero Image Upload -->
            <div class="bg-[#0f1623] rounded-xl p-6 border border-[#2a3548]">
                <label class="block text-sm font-medium text-gray-300 mb-3">صورة البطل الرئيسية</label>
                
                <!-- Image Preview -->
                @if ($heroImagePreview)
                    <div class="mb-4 relative group">
                        <img src="{{ $heroImagePreview }}" alt="Hero Preview" class="w-full h-64 object-cover rounded-lg">
                        <button type="button" wire:click="deleteHeroImage" 
                                class="absolute top-2 left-2 p-2 bg-red-500 text-white rounded-lg opacity-0 group-hover:opacity-100 transition-opacity">
                            <i class="ri-delete-bin-line"></i>
                        </button>
                    </div>
                @endif

                <!-- File Input -->
                <div class="flex items-center justify-center w-full">
                    <label class="flex flex-col items-center justify-center w-full h-32 border-2 border-dashed border-[#2a3548] rounded-lg cursor-pointer hover:border-primary/50 transition-all duration-300">
                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                            <i class="ri-upload-cloud-line text-4xl text-gray-400 mb-2"></i>
                            <p class="mb-2 text-sm text-gray-400">
                                <span class="font-semibold">اضغط لرفع الصورة</span> أو اسحب وأفلت
                            </p>
                            <p class="text-xs text-gray-500">PNG, JPG أو WEBP (الحد الأقصى 2MB)</p>
                        </div>
                        <input type="file" wire:model="heroImage" class="hidden" accept="image/*" />
                    </label>
                </div>

                @error('heroImage') 
                    <span class="text-red-400 text-sm mt-2 block">{{ $message }}</span> 
                @enderror

                <div wire:loading wire:target="heroImage" class="mt-2 text-primary text-sm">
                    <i class="ri-loader-4-line animate-spin ml-2"></i>
                    جاري رفع الصورة...
                </div>
            </div>

            <!-- Hero Title -->
            <div class="bg-[#0f1623] rounded-xl p-6 border border-[#2a3548]">
                <label class="block text-sm font-medium text-gray-300 mb-3">عنوان البطل</label>
                <input type="text" wire:model="heroTitle" 
                       class="w-full px-4 py-3 bg-[#121827] border border-[#2a3548] rounded-lg text-white placeholder-gray-500 focus:outline-none focus:border-primary transition-colors"
                       placeholder="أدخل عنوان البطل">
                @error('heroTitle') 
                    <span class="text-red-400 text-sm mt-2 block">{{ $message }}</span> 
                @enderror
            </div>

            <!-- Hero Description -->
            <div class="bg-[#0f1623] rounded-xl p-6 border border-[#2a3548]">
                <label class="block text-sm font-medium text-gray-300 mb-3">وصف البطل</label>
                <textarea wire:model="heroDescription" rows="4"
                          class="w-full px-4 py-3 bg-[#121827] border border-[#2a3548] rounded-lg text-white placeholder-gray-500 focus:outline-none focus:border-primary transition-colors"
                          placeholder="أدخل وصف البطل"></textarea>
                @error('heroDescription') 
                    <span class="text-red-400 text-sm mt-2 block">{{ $message }}</span> 
                @enderror
            </div>

            <!-- Hero Button -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-[#0f1623] rounded-xl p-6 border border-[#2a3548]">
                    <label class="block text-sm font-medium text-gray-300 mb-3">نص الزر</label>
                    <input type="text" wire:model="heroButtonText" 
                           class="w-full px-4 py-3 bg-[#121827] border border-[#2a3548] rounded-lg text-white placeholder-gray-500 focus:outline-none focus:border-primary transition-colors"
                           placeholder="اكتشف المزيد">
                </div>
                <div class="bg-[#0f1623] rounded-xl p-6 border border-[#2a3548]">
                    <label class="block text-sm font-medium text-gray-300 mb-3">رابط الزر</label>
                    <input type="text" wire:model="heroButtonLink" 
                           class="w-full px-4 py-3 bg-[#121827] border border-[#2a3548] rounded-lg text-white placeholder-gray-500 focus:outline-none focus:border-primary transition-colors"
                           placeholder="/products">
                </div>
            </div>
        </div>

        <!-- Banner Section Tab -->
        <div x-data="{ activeTab: 'hero' }" x-show="activeTab === 'banner'" class="space-y-6">
            <h3 class="text-xl font-bold text-white mb-4 flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg bg-gradient-to-r from-orange-500/20 to-red-500/20 flex items-center justify-center">
                    <i class="ri-landscape-line text-orange-400"></i>
                </div>
                قسم البانر (Banner Section)
            </h3>

            <!-- Banner Image Upload -->
            <div class="bg-[#0f1623] rounded-xl p-6 border border-[#2a3548]">
                <label class="block text-sm font-medium text-gray-300 mb-3">صورة البانر</label>
                
                <!-- Image Preview -->
                @if ($bannerImagePreview)
                    <div class="mb-4 relative group">
                        <img src="{{ $bannerImagePreview }}" alt="Banner Preview" class="w-full h-48 object-cover rounded-lg">
                        <button type="button" wire:click="deleteBannerImage" 
                                class="absolute top-2 left-2 p-2 bg-red-500 text-white rounded-lg opacity-0 group-hover:opacity-100 transition-opacity">
                            <i class="ri-delete-bin-line"></i>
                        </button>
                    </div>
                @endif

                <!-- File Input -->
                <div class="flex items-center justify-center w-full">
                    <label class="flex flex-col items-center justify-center w-full h-32 border-2 border-dashed border-[#2a3548] rounded-lg cursor-pointer hover:border-primary/50 transition-all duration-300">
                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                            <i class="ri-upload-cloud-line text-4xl text-gray-400 mb-2"></i>
                            <p class="mb-2 text-sm text-gray-400">
                                <span class="font-semibold">اضغط لرفع الصورة</span> أو اسحب وأفلت
                            </p>
                            <p class="text-xs text-gray-500">PNG, JPG أو WEBP (الحد الأقصى 2MB)</p>
                        </div>
                        <input type="file" wire:model="bannerImage" class="hidden" accept="image/*" />
                    </label>
                </div>

                @error('bannerImage') 
                    <span class="text-red-400 text-sm mt-2 block">{{ $message }}</span> 
                @enderror

                <div wire:loading wire:target="bannerImage" class="mt-2 text-primary text-sm">
                    <i class="ri-loader-4-line animate-spin ml-2"></i>
                    جاري رفع الصورة...
                </div>
            </div>

            <!-- Banner Title -->
            <div class="bg-[#0f1623] rounded-xl p-6 border border-[#2a3548]">
                <label class="block text-sm font-medium text-gray-300 mb-3">عنوان البانر</label>
                <input type="text" wire:model="bannerTitle" 
                       class="w-full px-4 py-3 bg-[#121827] border border-[#2a3548] rounded-lg text-white placeholder-gray-500 focus:outline-none focus:border-primary transition-colors"
                       placeholder="أدخل عنوان البانر">
            </div>

            <!-- Banner Description -->
            <div class="bg-[#0f1623] rounded-xl p-6 border border-[#2a3548]">
                <label class="block text-sm font-medium text-gray-300 mb-3">وصف البانر</label>
                <textarea wire:model="bannerDescription" rows="3"
                          class="w-full px-4 py-3 bg-[#121827] border border-[#2a3548] rounded-lg text-white placeholder-gray-500 focus:outline-none focus:border-primary transition-colors"
                          placeholder="أدخل وصف البانر"></textarea>
            </div>

            <!-- Banner Link -->
            <div class="bg-[#0f1623] rounded-xl p-6 border border-[#2a3548]">
                <label class="block text-sm font-medium text-gray-300 mb-3">رابط البانر</label>
                <input type="text" wire:model="bannerLink" 
                       class="w-full px-4 py-3 bg-[#121827] border border-[#2a3548] rounded-lg text-white placeholder-gray-500 focus:outline-none focus:border-primary transition-colors"
                       placeholder="/offers">
            </div>
        </div>

        <!-- Custom Data Tab -->
        <div x-data="{ activeTab: 'hero', newKey: '', newValue: '' }" x-show="activeTab === 'custom'" class="space-y-6">
            <h3 class="text-xl font-bold text-white mb-4 flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg bg-gradient-to-r from-purple-500/20 to-pink-500/20 flex items-center justify-center">
                    <i class="ri-settings-3-line text-purple-400"></i>
                </div>
                بيانات مخصصة (Custom Data)
            </h3>

            <div class="bg-[#0f1623] rounded-xl p-6 border border-[#2a3548]">
                <p class="text-gray-400 mb-4">يمكنك إضافة بيانات مخصصة إضافية يحتاجها الثيم</p>

                <!-- Current Custom Data -->
                @if(count($customData) > 0)
                    <div class="space-y-3 mb-4">
                        @foreach($customData as $key => $value)
                            <div class="flex items-center gap-3 bg-[#121827] p-4 rounded-lg border border-[#2a3548]">
                                <div class="flex-1 grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="text-xs text-gray-500 block mb-1">المفتاح</label>
                                        <div class="text-white font-mono">{{ $key }}</div>
                                    </div>
                                    <div>
                                        <label class="text-xs text-gray-500 block mb-1">القيمة</label>
                                        <div class="text-white">{{ $value }}</div>
                                    </div>
                                </div>
                                <button type="button" wire:click="removeCustomDataField('{{ $key }}')" 
                                        class="p-2 bg-red-500/20 text-red-400 rounded-lg hover:bg-red-500/30 transition-colors">
                                    <i class="ri-delete-bin-line"></i>
                                </button>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8 text-gray-500">
                        <i class="ri-database-line text-4xl mb-2"></i>
                        <p>لا توجد بيانات مخصصة بعد</p>
                    </div>
                @endif

                <!-- Add New Field -->
                <div class="border-t border-[#2a3548] pt-4 mt-4">
                    <p class="text-sm text-gray-400 mb-3">إضافة حقل جديد</p>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <input type="text" x-model="newKey" 
                               class="px-4 py-3 bg-[#121827] border border-[#2a3548] rounded-lg text-white placeholder-gray-500 focus:outline-none focus:border-primary transition-colors"
                               placeholder="المفتاح (مثال: secondary_color)">
                        <input type="text" x-model="newValue" 
                               class="px-4 py-3 bg-[#121827] border border-[#2a3548] rounded-lg text-white placeholder-gray-500 focus:outline-none focus:border-primary transition-colors"
                               placeholder="القيمة (مثال: #ff5733)">
                    </div>
                    <button type="button" 
                            @click="if(newKey && newValue) { $wire.addCustomDataField(newKey, newValue); newKey = ''; newValue = ''; }"
                            class="mt-3 px-6 py-3 bg-gradient-to-r from-primary to-secondary text-white rounded-lg hover:opacity-90 transition-opacity">
                        <i class="ri-add-line ml-2"></i>
                        إضافة حقل
                    </button>
                </div>
            </div>
        </div>

        <!-- Custom CSS/JS Tab -->
        <div x-data="{ activeTab: 'hero' }" x-show="activeTab === 'code'" class="space-y-6">
            <h3 class="text-xl font-bold text-white mb-4 flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg bg-gradient-to-r from-blue-500/20 to-cyan-500/20 flex items-center justify-center">
                    <i class="ri-code-line text-blue-400"></i>
                </div>
                أكواد CSS/JS مخصصة
            </h3>

            <!-- Custom CSS -->
            <div class="bg-[#0f1623] rounded-xl p-6 border border-[#2a3548]">
                <label class="block text-sm font-medium text-gray-300 mb-3">CSS مخصص</label>
                <textarea wire:model="customCss" rows="10"
                          class="w-full px-4 py-3 bg-[#121827] border border-[#2a3548] rounded-lg text-white placeholder-gray-500 focus:outline-none focus:border-primary transition-colors font-mono text-sm"
                          placeholder="/* أدخل كود CSS المخصص هنا */"></textarea>
            </div>

            <!-- Custom JS -->
            <div class="bg-[#0f1623] rounded-xl p-6 border border-[#2a3548]">
                <label class="block text-sm font-medium text-gray-300 mb-3">JavaScript مخصص</label>
                <textarea wire:model="customJs" rows="10"
                          class="w-full px-4 py-3 bg-[#121827] border border-[#2a3548] rounded-lg text-white placeholder-gray-500 focus:outline-none focus:border-primary transition-colors font-mono text-sm"
                          placeholder="// أدخل كود JavaScript المخصص هنا"></textarea>
            </div>
        </div>

        <!-- Save Button -->
        <div class="mt-8 flex items-center justify-end gap-4 border-t border-[#2a3548] pt-6">
            <button type="submit" 
                    wire:loading.attr="disabled"
                    class="px-8 py-4 bg-gradient-to-r from-primary to-secondary text-white font-semibold rounded-xl hover:opacity-90 transition-all duration-300 shadow-lg hover:shadow-xl flex items-center gap-3">
                <i class="ri-save-line text-xl"></i>
                <span wire:loading.remove wire:target="save">حفظ التغييرات</span>
                <span wire:loading wire:target="save">جاري الحفظ...</span>
            </button>
        </div>
    </form>

    <style>
        @keyframes fade-in {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .animate-fade-in {
            animation: fade-in 0.3s ease-out;
        }
    </style>
</div>
