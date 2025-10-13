<?php

namespace App\Livewire;

use App\Models\ThemeData;
use App\Models\Setting;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class ThemeCustomizer extends Component
{
    use WithFileUploads;

    public $themeData;
    public $themeName;
    
    // Hero section
    public $heroTitle;
    public $heroDescription;
    public $heroButtonText;
    public $heroButtonLink;
    public $heroImage;
    public $heroImagePreview;
    
    // Banner section
    public $bannerTitle;
    public $bannerDescription;
    public $bannerLink;
    public $bannerImage;
    public $bannerImagePreview;
    
    // Extra images
    public $extraImages = [];
    public $extraImagePreviews = [];
    
    // Custom data
    public $customData = [];
    
    // Custom CSS/JS
    public $customCss;
    public $customJs;
    
    public function mount()
    {
        $storeId = auth()->user()->store_id ?? null;
        $this->themeName = Setting::get('active_theme', 'default');
        
        $this->themeData = ThemeData::where('store_id', $storeId)
            ->where('theme_name', $this->themeName)
            ->first();
        
        if (!$this->themeData) {
            $this->themeData = ThemeData::create([
                'store_id' => $storeId,
                'theme_name' => $this->themeName,
                'is_active' => true,
            ]);
        }
        
        $this->loadData();
    }
    
    public function loadData()
    {
        // Load hero data
        $heroData = $this->themeData->hero_data ?? [];
        $this->heroTitle = $heroData['title'] ?? '';
        $this->heroDescription = $heroData['description'] ?? '';
        $this->heroButtonText = $heroData['button_text'] ?? '';
        $this->heroButtonLink = $heroData['button_link'] ?? '';
        if (isset($heroData['main_image'])) {
            $this->heroImagePreview = Storage::url($heroData['main_image']);
        }
        
        // Load banner data
        $bannerData = $this->themeData->banner_data ?? [];
        $this->bannerTitle = $bannerData['title'] ?? '';
        $this->bannerDescription = $bannerData['description'] ?? '';
        $this->bannerLink = $bannerData['link'] ?? '';
        if (isset($bannerData['main_image'])) {
            $this->bannerImagePreview = Storage::url($bannerData['main_image']);
        }
        
        // Load custom data
        $this->customData = $this->themeData->custom_data ?? [];
        
        // Load custom CSS/JS
        $this->customCss = $this->themeData->custom_css ?? '';
        $this->customJs = $this->themeData->custom_js ?? '';
    }
    
    public function updatedHeroImage()
    {
        $this->validate([
            'heroImage' => 'image|max:2048',
        ]);
        
        $this->heroImagePreview = $this->heroImage->temporaryUrl();
    }
    
    public function updatedBannerImage()
    {
        $this->validate([
            'bannerImage' => 'image|max:2048',
        ]);
        
        $this->bannerImagePreview = $this->bannerImage->temporaryUrl();
    }
    
    public function save()
    {
        $this->validate([
            'heroTitle' => 'nullable|string|max:255',
            'heroDescription' => 'nullable|string',
            'heroButtonText' => 'nullable|string|max:100',
            'heroButtonLink' => 'nullable|string|max:255',
            'heroImage' => 'nullable|image|max:2048',
            'bannerTitle' => 'nullable|string|max:255',
            'bannerDescription' => 'nullable|string',
            'bannerLink' => 'nullable|string|max:255',
            'bannerImage' => 'nullable|image|max:2048',
            'customCss' => 'nullable|string',
            'customJs' => 'nullable|string',
        ]);
        
        // Update hero data
        $heroData = $this->themeData->hero_data ?? [];
        $heroData['title'] = $this->heroTitle;
        $heroData['description'] = $this->heroDescription;
        $heroData['button_text'] = $this->heroButtonText;
        $heroData['button_link'] = $this->heroButtonLink;
        
        // Handle hero image upload
        if ($this->heroImage) {
            // Delete old image if exists
            if (isset($heroData['main_image'])) {
                Storage::disk('public')->delete($heroData['main_image']);
            }
            
            $path = $this->heroImage->store('themes/' . $this->themeName . '/hero', 'public');
            $heroData['main_image'] = $path;
        }
        
        $this->themeData->hero_data = $heroData;
        
        // Update banner data
        $bannerData = $this->themeData->banner_data ?? [];
        $bannerData['title'] = $this->bannerTitle;
        $bannerData['description'] = $this->bannerDescription;
        $bannerData['link'] = $this->bannerLink;
        
        // Handle banner image upload
        if ($this->bannerImage) {
            // Delete old image if exists
            if (isset($bannerData['main_image'])) {
                Storage::disk('public')->delete($bannerData['main_image']);
            }
            
            $path = $this->bannerImage->store('themes/' . $this->themeName . '/banner', 'public');
            $bannerData['main_image'] = $path;
        }
        
        $this->themeData->banner_data = $bannerData;
        
        // Update custom data
        $this->themeData->custom_data = $this->customData;
        
        // Update custom CSS/JS
        $this->themeData->custom_css = $this->customCss;
        $this->themeData->custom_js = $this->customJs;
        
        $this->themeData->save();
        
        // Reset file uploads
        $this->heroImage = null;
        $this->bannerImage = null;
        
        $this->dispatch('theme-saved');
        session()->flash('message', 'تم حفظ إعدادات الثيم بنجاح');
    }
    
    public function deleteHeroImage()
    {
        $heroData = $this->themeData->hero_data ?? [];
        
        if (isset($heroData['main_image'])) {
            Storage::disk('public')->delete($heroData['main_image']);
            unset($heroData['main_image']);
            $this->themeData->hero_data = $heroData;
            $this->themeData->save();
            
            $this->heroImagePreview = null;
            session()->flash('message', 'تم حذف صورة البطل بنجاح');
        }
    }
    
    public function deleteBannerImage()
    {
        $bannerData = $this->themeData->banner_data ?? [];
        
        if (isset($bannerData['main_image'])) {
            Storage::disk('public')->delete($bannerData['main_image']);
            unset($bannerData['main_image']);
            $this->themeData->banner_data = $bannerData;
            $this->themeData->save();
            
            $this->bannerImagePreview = null;
            session()->flash('message', 'تم حذف صورة البانر بنجاح');
        }
    }
    
    public function addCustomDataField($key, $value)
    {
        $this->customData[$key] = $value;
    }
    
    public function removeCustomDataField($key)
    {
        unset($this->customData[$key]);
    }
    
    public function render()
    {
        return view('livewire.theme-customizer');
    }
}
