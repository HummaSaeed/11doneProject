<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use App\Models\HomePage\PackageSection;
use App\Models\Package;


class PricingController extends Controller
{
  public function index()
  {
    $misc = new MiscellaneousController();
    $language = $misc->getLanguage();
    $queryResult['seoInfo'] = $language->seoInfo()->select('meta_keyword_pricing', 'meta_description_pricing')->first();
    $language = $misc->getLanguage();

    $terms = [];
    if (Package::query()->where('status', '1')->where('term', 'monthly')->count() > 0) {
      $terms[] = 'Monthly';
    }
    if (Package::query()->where('status', '1')->where('term', 'yearly')->count() > 0) {
      $terms[] = 'Yearly';
    }
    if (Package::query()->where('status', '1')->where('term', 'lifetime')->count() > 0) {
      $terms[] = 'Lifetime';
    }

    $queryResult['terms'] = $terms;


    $queryResult['pageHeading'] = $misc->getPageHeading($language);
    $queryResult['bgImg'] = $misc->getBreadcrumb();
    return view('frontend.pricing', $queryResult);
  }
}
