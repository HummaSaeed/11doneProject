<!-- Page title start-->
<div class="page-title-area bg-img bg-cover header-next {{ $basicInfo->theme_version == 2 || $basicInfo->theme_version == 3 ? 'has_header_2' : '' }}"
    @if (!empty($breadcrumb)) data-bg-image="{{ asset('assets/img/' . $breadcrumb) }}" @endif>
    <div class="container">
        <div class="content">
            <h2>{{ !empty($title) ? $title : '' }}</h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('index') }}">{{ __('Home') }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ !empty($title) ? $title : '' }}</li>
                </ol>
            </nav>
        </div>
    </div>
</div>
<!-- Page title end-->
