<?php

namespace App\Models;

use App\Models\BasicSettings\AboutUs;
use App\Models\BasicSettings\CookieAlert;
use App\Models\BasicSettings\PageHeading;
use App\Models\BasicSettings\SEO;
use App\Models\CustomPage\PageContent;
use App\Models\FAQ;
use App\Models\Footer\FooterContent;
use App\Models\Footer\QuickLink;
use App\Models\HomePage\Banner;
use App\Models\HomePage\Methodology\WorkProcess;
use App\Models\HomePage\Testimony\Testimonial;
use App\Models\Journal\BlogCategory;
use App\Models\Journal\BlogInformation;
use App\Models\MenuBuilder;
use App\Models\Popup;
use App\Models\Services\ServiceCategory;
use App\Models\Services\ServiceContent;
use App\Models\Shop\ProductCategory;
use App\Models\Shop\ProductContent;
use App\Models\Shop\ShippingCharge;
use App\Models\Staff\StaffContent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
  use HasFactory;

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = ['name', 'code', 'direction', 'is_default'];

  public function faq()
  {
    return $this->hasMany(FAQ::class);
  }

  public function customPageInfo()
  {
    return $this->hasMany(PageContent::class);
  }

  public function footerContent()
  {
    return $this->hasOne(FooterContent::class);
  }

  public function footerQuickLink()
  {
    return $this->hasMany(QuickLink::class);
  }

  public function announcementPopup()
  {
    return $this->hasMany(Popup::class);
  }

  public function blogCategory()
  {
    return $this->hasMany(BlogCategory::class);
  }

  public function blogInformation()
  {
    return $this->hasMany(BlogInformation::class);
  }

  public function menuInfo()
  {
    return $this->hasOne(MenuBuilder::class, 'language_id', 'id');
  }

  public function aboutSection()
  {
    return $this->belongsTo(AboutUs::class);
  }


  public function workProcess()
  {
    return $this->hasMany(WorkProcess::class, 'language_id', 'id');
  }

  public function features()
  {
    return $this->hasMany(Features::class, 'language_id', 'id');
  }

  public function testimonial()
  {
    return $this->hasMany(Testimonial::class, 'language_id', 'id');
  }

  public function serviceCategory()
  {
    return $this->hasMany(ServiceCategory::class, 'language_id', 'id');
  }

/** */
  public function aboutUsSection()
  {
    return $this->hasOne(AboutUs::class, 'language_id', 'id');
  }
  public function featuresInfos()
  {
    return $this->hasMany(Features::class, 'language_id', 'id');
  }

  public function shippingCharge()
  {
    return $this->hasMany(ShippingCharge::class);
  }
  public function serviceContent()
  {
    return $this->hasMany(ServiceContent::class, 'language_id', 'id');
  }

  public function productCategory()
  {
    return $this->hasMany(ProductCategory::class);
  }

  public function staffContent()
  {
    return $this->hasMany(StaffContent::class);
  }

  public function productContent()
  {
    return $this->hasMany(ProductContent::class);
  }

  public function vendorInfo()
  {
    return $this->hasOne(VendorInfo::class);
  }


  public function banner()
  {
    return $this->hasOne(Banner::class);
  }
  public function pageName()
  {
    return $this->hasOne(PageHeading::class);
  }

  public function seoInfo()
  {
    return $this->hasOne(SEO::class);
  }
  public function cookieAlertInfo()
  {
    return $this->hasOne(CookieAlert::class);
  }
}
