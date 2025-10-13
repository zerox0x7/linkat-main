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
    
    // Hero section - Multiple slides (up to 6)
    public $heroSlides = [];
    public $newHeroSlide = [
        'title' => '',
        'subtitle' => '',
        'button_text' => '',
        'button_link' => '',
        'image' => null,
        'image_preview' => null,
    ];
    public $editingSlideIndex = null;
    public $tempSlideImage;
    
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
        // Load hero slides data
        $heroData = $this->themeData->hero_data ?? [];
        $this->heroSlides = $heroData['slides'] ?? [];
        
        // Add image preview URLs for existing slides
        foreach ($this->heroSlides as $index => $slide) {
            if (isset($slide['image'])) {
                $this->heroSlides[$index]['image_preview'] = Storage::url($slide['image']);
            }
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
    
    public function updatedTempSlideImage()
    {
        $this->validate([
            'tempSlideImage' => 'image|max:2048',
        ]);
        
        if ($this->editingSlideIndex !== null) {
            $this->heroSlides[$this->editingSlideIndex]['image_preview'] = $this->tempSlideImage->temporaryUrl();
        } else {
            $this->newHeroSlide['image_preview'] = $this->tempSlideImage->temporaryUrl();
        }
    }
    
    public function updatedBannerImage()
    {
        $this->validate([
            'bannerImage' => 'image|max:2048',
        ]);
        
        $this->bannerImagePreview = $this->bannerImage->temporaryUrl();
    }
    
    public function addHeroSlide()
    {
        if (count($this->heroSlides) >= 6) {
            session()->flash('error', 'لا يمكن إضافة أكثر من 6 صور للبطل');
            return;
        }
        
        $this->validate([
            'newHeroSlide.title' => 'required|string|max:255',
            'newHeroSlide.subtitle' => 'nullable|string|max:500',
            'newHeroSlide.button_text' => 'nullable|string|max:100',
            'newHeroSlide.button_link' => 'nullable|string|max:255',
            'tempSlideImage' => 'required|image|max:2048',
        ], [
            'newHeroSlide.title.required' => 'العنوان مطلوب',
            'tempSlideImage.required' => 'الصورة مطلوبة',
            'tempSlideImage.image' => 'يجب أن يكون الملف صورة',
            'tempSlideImage.max' => 'حجم الصورة يجب أن لا يتجاوز 2MB',
        ]);
        
        // Upload image
        $path = $this->tempSlideImage->store('themes/' . $this->themeName . '/hero', 'public');
        
        // Add new slide
        $this->heroSlides[] = [
            'id' => uniqid(),
            'title' => $this->newHeroSlide['title'],
            'subtitle' => $this->newHeroSlide['subtitle'],
            'button_text' => $this->newHeroSlide['button_text'],
            'button_link' => $this->newHeroSlide['button_link'],
            'image' => $path,
            'image_preview' => Storage::url($path),
            'order' => count($this->heroSlides),
        ];
        
        // Save immediately
        $this->saveHeroSlides();
        
        // Reset form
        $this->resetNewHeroSlide();
        
        session()->flash('message', 'تم إضافة الصورة بنجاح');
    }
    
    public function editHeroSlide($index)
    {
        $this->editingSlideIndex = $index;
        $this->newHeroSlide = $this->heroSlides[$index];
        $this->newHeroSlide['image_preview'] = $this->heroSlides[$index]['image_preview'] ?? null;
    }
    
    public function updateHeroSlide()
    {
        if ($this->editingSlideIndex === null) {
            return;
        }
        
        $this->validate([
            'newHeroSlide.title' => 'required|string|max:255',
            'newHeroSlide.subtitle' => 'nullable|string|max:500',
            'newHeroSlide.button_text' => 'nullable|string|max:100',
            'newHeroSlide.button_link' => 'nullable|string|max:255',
            'tempSlideImage' => 'nullable|image|max:2048',
        ], [
            'newHeroSlide.title.required' => 'العنوان مطلوب',
        ]);
        
        // Update slide data
        $this->heroSlides[$this->editingSlideIndex]['title'] = $this->newHeroSlide['title'];
        $this->heroSlides[$this->editingSlideIndex]['subtitle'] = $this->newHeroSlide['subtitle'];
        $this->heroSlides[$this->editingSlideIndex]['button_text'] = $this->newHeroSlide['button_text'];
        $this->heroSlides[$this->editingSlideIndex]['button_link'] = $this->newHeroSlide['button_link'];
        
        // Update image if new one uploaded
        if ($this->tempSlideImage) {
            // Delete old image
            if (isset($this->heroSlides[$this->editingSlideIndex]['image'])) {
                Storage::disk('public')->delete($this->heroSlides[$this->editingSlideIndex]['image']);
            }
            
            $path = $this->tempSlideImage->store('themes/' . $this->themeName . '/hero', 'public');
            $this->heroSlides[$this->editingSlideIndex]['image'] = $path;
            $this->heroSlides[$this->editingSlideIndex]['image_preview'] = Storage::url($path);
        }
        
        // Save
        $this->saveHeroSlides();
        
        // Reset form
        $this->resetNewHeroSlide();
        $this->editingSlideIndex = null;
        
        session()->flash('message', 'تم تحديث الصورة بنجاح');
    }
    
    public function cancelEdit()
    {
        $this->resetNewHeroSlide();
        $this->editingSlideIndex = null;
    }
    
    public function deleteHeroSlide($index)
    {
        if (isset($this->heroSlides[$index])) {
            // Delete image from storage
            if (isset($this->heroSlides[$index]['image'])) {
                Storage::disk('public')->delete($this->heroSlides[$index]['image']);
            }
            
            // Remove slide
            unset($this->heroSlides[$index]);
            $this->heroSlides = array_values($this->heroSlides); // Re-index array
            
            // Save
            $this->saveHeroSlides();
            
            session()->flash('message', 'تم حذف الصورة بنجاح');
        }
    }
    
    public function moveSlideUp($index)
    {
        if ($index > 0) {
            $temp = $this->heroSlides[$index];
            $this->heroSlides[$index] = $this->heroSlides[$index - 1];
            $this->heroSlides[$index - 1] = $temp;
            
            $this->saveHeroSlides();
            session()->flash('message', 'تم تغيير ترتيب الصورة');
        }
    }
    
    public function moveSlideDown($index)
    {
        if ($index < count($this->heroSlides) - 1) {
            $temp = $this->heroSlides[$index];
            $this->heroSlides[$index] = $this->heroSlides[$index + 1];
            $this->heroSlides[$index + 1] = $temp;
            
            $this->saveHeroSlides();
            session()->flash('message', 'تم تغيير ترتيب الصورة');
        }
    }
    
    public function reorderSlides($orderedIds)
    {
        // Create a map of slides by their IDs
        $slidesMap = [];
        foreach ($this->heroSlides as $slide) {
            if (isset($slide['id'])) {
                $slidesMap[$slide['id']] = $slide;
            }
        }
        
        // Reorder slides based on the new order
        $reorderedSlides = [];
        foreach ($orderedIds as $id) {
            if (isset($slidesMap[$id])) {
                $reorderedSlides[] = $slidesMap[$id];
            }
        }
        
        $this->heroSlides = $reorderedSlides;
        $this->saveHeroSlides();
        
        session()->flash('message', 'تم إعادة ترتيب الصور بنجاح');
    }
    
    private function resetNewHeroSlide()
    {
        $this->newHeroSlide = [
            'title' => '',
            'subtitle' => '',
            'button_text' => '',
            'button_link' => '',
            'image' => null,
            'image_preview' => null,
        ];
        $this->tempSlideImage = null;
    }
    
    private function saveHeroSlides()
    {
        $heroData = $this->themeData->hero_data ?? [];
        
        // Clean slides data (remove preview URLs)
        $slidesToSave = array_map(function($slide) {
            unset($slide['image_preview']);
            return $slide;
        }, $this->heroSlides);
        
        $heroData['slides'] = $slidesToSave;
        $this->themeData->hero_data = $heroData;
        $this->themeData->save();
    }
    
    public function save()
    {
        $this->validate([
            'bannerTitle' => 'nullable|string|max:255',
            'bannerDescription' => 'nullable|string',
            'bannerLink' => 'nullable|string|max:255',
            'bannerImage' => 'nullable|image|max:2048',
            'customCss' => 'nullable|string',
            'customJs' => 'nullable|string',
        ]);
        
        // Hero slides are saved separately via addHeroSlide/updateHeroSlide/deleteHeroSlide
        
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
        $this->bannerImage = null;
        
        $this->dispatch('theme-saved');
        session()->flash('message', 'تم حفظ إعدادات الثيم بنجاح');
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
