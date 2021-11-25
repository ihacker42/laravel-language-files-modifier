<?php $langArray		=	['en'=>'English','hi'=>'हिन्दी']; ?>
<div class="left side-menu">
    <div class="slimscroll-menu" id="remove-scroll">
        <div id="sidebar-menu">
            <ul class="metismenu" id="side-menu">
				<li>   
					<a href="javascript:void(0);" class="waves-effect"><i class="fas fa-language"></i><span> {{ array_key_exists(App::getLocale(),$langArray) ?  $langArray[App::getLocale()] : 'English' }} <span class="float-right menu-arrow"><i class="mdi mdi-chevron-right"></i></span> </span></a>
					<ul class="submenu">
						<li><a rel="alternate" hreflang="en" href="/">English</a></li>
						<li><a rel="alternate" hreflang="hi" href="/hi">हिन्दी</a></li>
					</ul>
                </li>
                
                <li><a href="{{route('Lang.getFiles')}}" class="waves-effect" title="All Files"><i class="fas fa-file"></i><span>All Files</span></a></li>
                
                <li><a href="{{route('Lang.createFile')}}" class="waves-effect" title="Create File"><i class="fas fa-file"></i><span>Create File</span></a></li>

            </ul>
        </div>
        <div class="clearfix"></div>
    </div>
</div>