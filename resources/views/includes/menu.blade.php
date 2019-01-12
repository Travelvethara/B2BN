<?php 


$notification_badge = 0;

$whologin_n = 0;
$notification_badge_n = 0;
if(Auth::user()->user_type == 'AgencyManger') {
	
	$agencylistm =DB::table('agency')->where('loginid','=',Auth::user()->id)->get();
	$notification_badge =DB::table('agency')->where('notification_badge','=','1')->get();
	
	
	
    $notification_badge =DB::table('agency')->where('notification_badge','=','1')->where('parentagencyid','!=',$agencylistm[0]->id)->get(); /*echo '<pre>'; print_r(count($notification_badge)); echo '</pre>'; exit;*/

    $notification_badge_n = count($notification_badge); 

}

if(Auth::user()->user_type == 'SuperAdmin') {
$notification_badge =DB::table('agency')->where('notification_badge','=','1')->get(); /*echo '<pre>'; print_r(count($notification_badge)); echo '</pre>'; exit;*/
$AgencyDetails =DB::table('agency')->where('notification_staus','=','1')->where('delete_status','!=','0')->get();
$notification_badge_n = count($notification_badge); 
$whologin =DB::table('whologin')->where('staus','=',1)->get();
$whologin_n = count($whologin);
}
Session::put('user', 'mani');

//echo $user;

//$n_notificatin = $whologin_n + $notification_badge;
$n_notificatin = $whologin_n+$notification_badge_n;






 ?>
<button class="m-aside-left-close  m-aside-left-close--skin-dark " id="m_aside_left_close_btn">
	<i class="la la-close"></i>
</button>
<header id="m_header" class="m-grid__item m_header_dupplicate   m-header "  m-minimize-offset="200" m-minimize-mobile-offset="200" >
	<div class="m-container m-container--fluid ">
		<div class="m-stack m-stack--ver cust">
			<!-- BEGIN: Brand -->
			<div class="m-stack__item m-brand  m-brand--skin-dark ">
				<div class="m-stack m-stack--ver m-stack--general newcst">
					<div class="m-stack__item m-stack__item--middle m-brand__logo">
						<a href="{{route('home')}}" class="m-brand__logo-wrapper">
							<img alt="" src="{{asset('/img/white_logo_default_dark.png')}}"/>
						</a>
					</div>
					<div class="m-stack__item m-stack__item--middle m-brand__tools middle-tool">
						<!-- BEGIN: Left Aside Minimize Toggle -->
						<a href="javascript:;" id="m_aside_left_minimize_toggle" class="burgerbarclass m-brand__icon m-brand__toggler m-brand__toggler--left m--visible-desktop-inline-block 
						">
						<span></span>
					</a>
					<!-- END -->
					<!-- BEGIN: Responsive Aside Left Menu Toggler -->
					<a href="javascript:;" id="m_aside_left_offcanvas_toggle" class="m-brand__icon m-brand__toggler m-brand__toggler--left m--visible-tablet-and-mobile-inline-block">
						<span></span>
					</a>
					<!-- END -->
					<!-- BEGIN: Responsive Header Menu Toggler -->
									<!--<a id="m_aside_header_menu_mobile_toggle" href="javascript:;" class="m-brand__icon m-brand__toggler m--visible-tablet-and-mobile-inline-block">
										<span></span>
									</a>-->
									<!-- END -->
									<!-- BEGIN: Topbar Toggler -->
								<!--	<a id="m_aside_header_topbar_mobile_toggle" href="javascript:;" class="m-brand__icon m--visible-tablet-and-mobile-inline-block">
										<i class="fas fa-ellipsis-h"></i>
									</a>-->
									<!-- BEGIN: Topbar Toggler -->
								</div>
							</div>
							
						</div>
                        <?php /*?><div class="welcome" style="color:#fff;">
                          <img alt="" src="{{asset('/img/user4.png')}}"/>
                            	<p class="username-content">Welcome <?php if(Auth::user()->user_type == 'UserInfo') { ?> User <?php } ?><?php if(Auth::user()->user_type == 'AgencyManger') { ?> Agency Manager <?php } ?><?php if(Auth::user()->user_type == 'SuperAdmin') { ?> Super Admin <?php } ?></p>
                          
                                                                           </form>
                                 <a href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();" class="logoutc" title="Logout">Logout
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                   <input type="hidden" name="_token" value="<?php echo @csrf_token(); ?>">
                                 </form>
                                 </a>                                          
                        <a href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();" class="iconsignout signouticon" style="display:none;" title="Logout"><i class="m-menu__link-icon fa fa-sign-out" ></i> </a>                                         
                            
                                                     </div><?php */?>
                                                     <!-- END: Brand -->
                                                     
                                                 </div>
                                             </div>
                                         </header>
                                         <div id="m_aside_left" class="m-grid__item	m-aside-left  m-aside-left--skin-dark menuclass ">
                                         	<header id="m_header" class="m-grid__item    m-header "  m-minimize-offset="200" m-minimize-mobile-offset="200" >
                                         		<div class="m-container m-container--fluid ">
                                         			<div class="m-stack m-stack--ver cust">
                                         				<!-- BEGIN: Brand -->
                                         				<div class="m-stack__item m-brand  m-brand--skin-dark m-brand--skin-dark-respomenu  ">
                                         					<div class="m-stack m-stack--ver m-stack--general newcst">
                                         						<div class="m-stack__item m-stack__item--middle m-brand__logo">
                                         							<a href="{{route('home')}}" class="m-brand__logo-wrapper">
                                         								<img alt="" src="{{asset('/img/white_logo_default_dark.png')}}"/>
                                         							</a>
                                         						</div>
                                         						<div class="m-stack__item m-stack__item--middle m-brand__tools middletool">
                                         							<!-- BEGIN: Left Aside Minimize Toggle -->
                                         							<a href="javascript:;" id="m_aside_left_minimize_toggle" class="burgerbarclass m-brand__icon m-brand__toggler m-brand__toggler--left m--visible-desktop-inline-block 
                                         							">
                                         							<span></span>
                                         						</a>
                                         						<!-- END -->
                                         						<!-- BEGIN: Responsive Aside Left Menu Toggler -->
                                         						<a href="javascript:;" id="m_aside_left_offcanvas_toggle" class="m-brand__icon m-brand__toggler m-brand__toggler--left m--visible-tablet-and-mobile-inline-block">
                                         							<span></span>
                                         						</a>
                                         						<!-- END -->
                                         						<!-- BEGIN: Responsive Header Menu Toggler -->
									<!--<a id="m_aside_header_menu_mobile_toggle" href="javascript:;" class="m-brand__icon m-brand__toggler m--visible-tablet-and-mobile-inline-block">
										<span></span>-->
									</a>
									<!-- END -->
									<!-- BEGIN: Topbar Toggler -->
									<!--<a id="m_aside_header_topbar_mobile_toggle" href="javascript:;" class="m-brand__icon m--visible-tablet-and-mobile-inline-block">
										<i class="fas fa-ellipsis-h"></i>
									</a>-->
									<!-- BEGIN: Topbar Toggler -->
								</div>
							</div>
							
						</div>
						<!--<div class="welcome" style="color:#fff;">
							<img alt="" src="{{asset('/img/user4.png')}}" id="imagename"/>
							<p class="username-content">Welcome <?php if(Auth::user()->user_type == 'UserInfo') { ?> {{Auth::user()->name}} <?php } ?><?php if(Auth::user()->user_type == 'AgencyManger') { ?> {{$agencylistm[0]->aname}} <?php } ?><?php if(Auth::user()->user_type == 'SuperAdmin') { ?> Super Admin <?php } ?></p>
							
						</form>
						<a href="javascript:void(0);" class="logoutc" title="Logout">Logout
                        <input type="hidden" value="{{ route('logout') }}" id="logout_url"/>
                        
                        <input type="hidden" value="{{ url('/') }}" id="home_url"/>
                        <input type="hidden" value="{{ Auth::user()->id }}" id="logout_id"/>
						<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
							<input type="hidden" name="_token" value="<?php echo @csrf_token(); ?>">
						</form>
                        
                        <form id="logoutformnew" action="{{ route('whologin') }}" method="POST" style="display: none;">
                           <input type="hidden" name="_token" value="<?php echo @csrf_token(); ?>">
                           <input type="hidden" value="{{ route('logout') }}" id="logout_url"/>
                            <input type="hidden" value="{{ Auth::user()->id }}" id="loginid" name="loginid"/>
                        </form>
					</a>                                          
					<a href="{{ route('logout') }}" onclick="event.preventDefault();
					document.getElementById('logout-form').submit();" class="iconsignout signouticon" style="display:none;" title="Logout"><i class="m-menu__link-icon fa fa-sign-out" ></i> </a>                                         
					
				</div>-->
				<!-- END: Brand -->
				
			</div>
		</div>
	</header>
	<!-- BEGIN: Aside Menu -->
	<div id="m_ver_menu" 
	class="m-aside-menu  m-aside-menu--skin-dark m-aside-menu--submenu-skin-dark" 
	m-menu-vertical="1"
	m-menu-scrollable="0" m-menu-dropdown-timeout="500">
	<ul class="m-menu__nav  m-menu__nav--dropdown-submenu-arrow m-menu__nav--drop-submenu-arrow_res">
		<?php if(Auth::user()->user_type == 'SuperAdmin') { ?>
						   <!--<li class="choosemenu" data-href="{{route('agencylist')}}"><a href="javascript:void(0);"><i class="fas fa-user"></i> <b class="menuname">Agency</b><i class="fas fa-angle-right"></i></a></li>
    
						   <li class="choosemenu" data-href="{{route('rolelist')}}"><a href="javascript:void(0);"><i class="fas fa-key"></i> <b class="menuname">Role</b><i class="fas fa-angle-right"></i></a></li>

						   <li class="choosemenu" data-href="{{route('userlist')}}"><a href="javascript:void(0);"><i class="fas fa-users"></i> <b class="menuname">User</b><i class="fas fa-angle-right"></i></a></li> -->
						   
						   <li class="m-menu__item  m-menu__item--submenu " aria-haspopup="true" m-menu-submenu-toggle="hover"><a href="javascript:;" class="m-menu__link m-menu__toggle"><i class="m-menu__link-icon fas fa-user"></i><span class="m-menu__link-text">Agency</span><i class="m-menu__ver-arrow fas fa-angle-right"></i></a>
						   	<div class="m-menu__submenu "><span class="m-menu__arrow"></span><ul class="m-menu__subnav"><li class="m-menu__item  m-menu__item--parent" aria-haspopup="true"></li><li class="m-menu__item  m-menu__item--active" aria-haspopup="true"><a href="{{route('agency')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Create Agent</span></a></li></ul></div>
						   	<div class="m-menu__submenu "><span class="m-menu__arrow"></span><ul class="m-menu__subnav"><li class="m-menu__item  m-menu__item--parent" aria-haspopup="true"></li><li class="m-menu__item  m-menu__item--active" aria-haspopup="true"><a href="{{route('agencylist')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Agent List</span></a></li></ul></div>
						   	
						   </li>
                           
                           
                           <li class="m-menu__item  m-menu__item--submenu " aria-haspopup="true" m-menu-submenu-toggle="hover"><a href="javascript:;" class="m-menu__link m-menu__toggle"><i class="m-menu__link-icon fas fa-user"></i><span class="m-menu__link-text">Booking Report</span><i class="m-menu__ver-arrow fas fa-angle-right"></i></a>
						   	 
						   	   <div class="m-menu__submenu "><span class="m-menu__arrow"></span><ul class="m-menu__subnav"><li class="m-menu__item  m-menu__item--parent" aria-haspopup="true"></li><li class="m-menu__item  m-menu__item--active" aria-haspopup="true"><a href="{{route('unvouchecdbooking')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Booking Report</span></a></li></ul></div>
                               <div class="m-menu__submenu "><span class="m-menu__arrow"></span><ul class="m-menu__subnav"><li class="m-menu__item  m-menu__item--parent" aria-haspopup="true"></li><li class="m-menu__item  m-menu__item--active" aria-haspopup="true"><a href="{{route('agentbookingwise')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Agents Booking</span></a></li></ul></div>
                               <div class="m-menu__submenu "><span class="m-menu__arrow"></span><ul class="m-menu__subnav"><li class="m-menu__item  m-menu__item--parent" aria-haspopup="true"></li><li class="m-menu__item  m-menu__item--active" aria-haspopup="true"><a href="{{route('cancelledbooking')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Cancelled Booking</span></a></li></ul></div>
                               <div class="m-menu__submenu "><span class="m-menu__arrow"></span><ul class="m-menu__subnav"><li class="m-menu__item  m-menu__item--parent" aria-haspopup="true"></li><li class="m-menu__item  m-menu__item--active" aria-haspopup="true"><a href="{{route('agencyddetailbookingreport')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Invoice</span></a></li></ul></div>
						   	
						   </li>
                           
                           
                           
                           <li class="m-menu__item  m-menu__item--submenu " aria-haspopup="true" m-menu-submenu-toggle="hover"><a href="javascript:;" class="m-menu__link m-menu__toggle"><i class="m-menu__link-icon fas fa-user"></i><span class="m-menu__link-text">Admin Control</span><i class="m-menu__ver-arrow fas fa-angle-right"></i></a>
						   	   <div class="m-menu__submenu "><span class="m-menu__arrow"></span><ul class="m-menu__subnav"><li class="m-menu__item  m-menu__item--parent" aria-haspopup="true"></li><li class="m-menu__item  m-menu__item--active" aria-haspopup="true"><a href="{{route('adminApicontrol')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Admin Portal</span></a></li></ul></div>
                               <div class="m-menu__submenu "><span class="m-menu__arrow"></span><ul class="m-menu__subnav"><li class="m-menu__item  m-menu__item--parent" aria-haspopup="true"></li><li class="m-menu__item  m-menu__item--active" aria-haspopup="true"><a href="{{route('apiprofiledata')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">API Profile Data</span></a></li></ul></div>
						   </li>
                           
                           
                           
                           <li class="m-menu__item  m-menu__item--submenu " aria-haspopup="true" m-menu-submenu-toggle="hover"><a href="javascript:;" class="m-menu__link m-menu__toggle"><i class="m-menu__link-icon fas fa-user"></i><span class="m-menu__link-text">Hotel Search</span><i class="m-menu__ver-arrow fas fa-angle-right"></i></a>
						   	  <div class="m-menu__submenu "><span class="m-menu__arrow"></span><ul class="m-menu__subnav"><li class="m-menu__item  m-menu__item--parent" aria-haspopup="true"></li><li class="m-menu__item  m-menu__item--active" aria-haspopup="true"><a href="{{route('hotelsearch')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Hotel Search</span></a></li></ul></div>
						   	  
						   	
						   </li>
						   
						   <li class="m-menu__item  m-menu__item--submenu " aria-haspopup="true" m-menu-submenu-toggle="hover"><a href="javascript:;" class="m-menu__link m-menu__toggle"><i class="m-menu__link-icon fas fa-key"></i><span class="m-menu__link-text">Role</span><i class="m-menu__ver-arrow fas fa-angle-right"></i></a>
						   	<div class="m-menu__submenu "><span class="m-menu__arrow"></span><ul class="m-menu__subnav"><li class="m-menu__item  m-menu__item--parent" aria-haspopup="true"></li><li class="m-menu__item  m-menu__item--active" aria-haspopup="true"><a href="{{route('role')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Create Role</span></a></li></ul></div>
						   	
						   	<div class="m-menu__submenu "><span class="m-menu__arrow"></span><ul class="m-menu__subnav"><li class="m-menu__item  m-menu__item--parent" aria-haspopup="true"></li><li class="m-menu__item  m-menu__item--active" aria-haspopup="true"><a href="{{route('rolelist')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Role List</span></a></li></ul></div></li>
						   	
						   	<li class="m-menu__item  m-menu__item--submenu " aria-haspopup="true" m-menu-submenu-toggle="hover"><a href="javascript:;" class="m-menu__link m-menu__toggle"><i class="m-menu__link-icon fas fa-users"></i><span class="m-menu__link-text">User</span><i class="m-menu__ver-arrow fas fa-angle-right"></i></a>
						   		<div class="m-menu__submenu "><span class="m-menu__arrow"></span><ul class="m-menu__subnav"><li class="m-menu__item  m-menu__item--parent" aria-haspopup="true"></li><li class="m-menu__item  m-menu__item--active" aria-haspopup="true"><a href="{{route('user')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Create User</span></a></li></ul></div>
						   		<div class="m-menu__submenu "><span class="m-menu__arrow"></span><ul class="m-menu__subnav"><li class="m-menu__item  m-menu__item--parent" aria-haspopup="true"></li><li class="m-menu__item  m-menu__item--active" aria-haspopup="true"><a href="{{route('userlist')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">User List</span></a></li></ul></div></li>
                                
                                
                                <li class="m-menu__item  m-menu__item--submenu " aria-haspopup="true" m-menu-submenu-toggle="hover"><a href="javascript:;" class="m-menu__link m-menu__toggle"><i class="m-menu__link-icon fas fa-users"></i><span class="m-menu__link-text">Email Setting</span><i class="m-menu__ver-arrow fas fa-angle-right"></i></a>
						   		<div class="m-menu__submenu "><span class="m-menu__arrow"></span><ul class="m-menu__subnav"><li class="m-menu__item  m-menu__item--parent" aria-haspopup="true"></li><li class="m-menu__item  m-menu__item--active" aria-haspopup="true"><a href="{{route('adminemail')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Email Setting</span></a></li></ul></div>
						   		</li>
                                
                                	<!--<li class="m-menu__item  m-menu__item--submenu " aria-haspopup="true" m-menu-submenu-toggle="hover"><a href="javascript:;" class="m-menu__link m-menu__toggle"><i class="m-menu__link-icon fas fa-users"></i><span class="m-menu__link-text notificati_sum"> <span class="m-menu__link-badge">Notifications <span class="m-menu__link-badge"> <span class="m-badge m-badge--danger">{{$n_notificatin}}</span></span></span><i class="m-menu__ver-arrow fas fa-angle-right"></i></a>
                                    
						   		<div class="m-menu__submenu "><span class="m-menu__arrow"></span><ul class="m-menu__subnav">
                                <li class="m-menu__item  m-menu__item--parent" aria-haspopup="true"></li><li class="m-menu__item  m-menu__item--active" aria-haspopup="true"><a href="{{route('notification')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Agent
                               <?php if(count($notification_badge)) { ?>
                                <span class="m-menu__link-badge"><span class="m-badge m-badge--danger">{{count($notification_badge)}}</span></span>
                                <?php } ?>
                                </span></a></li>
                                
                                <li class="m-menu__item  m-menu__item--parent" aria-haspopup="true"></li><li class="m-menu__item  m-menu__item--active" aria-haspopup="true"><a href="{{route('loginnotification')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Active
                               
                                <span class="m-menu__link-badge"><span class="m-badge m-badge--danger">{{$whologin_n}}</span></span>
                                
                                </span></a></li>
                                
                                </ul></div>-->
						   		<!--<div class="m-menu__submenu "><span class="m-menu__arrow"></span>
                                
                                
                                <ul class="m-menu__subnav"><li class="m-menu__item  m-menu__item--parent" aria-haspopup="true"></li><li class="m-menu__item  m-menu__item--active" aria-haspopup="true"><a href="{{route('userlist')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">User List</span></a></li></ul></div>-->
                                
                                
                                </li>
                                
                                
						   		
						   		
						   		
						   		

						   	<?php }
						   	if(Auth::user()->user_type == 'AgencyManger') { ?>
						   		<li class="m-menu__item  m-menu__item--submenu " aria-haspopup="true" m-menu-submenu-toggle="hover"><a href="javascript:;" class="m-menu__link m-menu__toggle"><i class="m-menu__link-icon fas fa-user"></i><span class="m-menu__link-text">Agency</span><i class="m-menu__ver-arrow fas fa-angle-right"></i></a><div class="m-menu__submenu "><span class="m-menu__arrow"></span>
						   			<ul class="m-menu__subnav"><li class="m-menu__item  m-menu__item--parent" aria-haspopup="true"></li><li class="m-menu__item  m-menu__item--active" aria-haspopup="true"><a href="{{route('agency')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Create Sub-Agent</span></a></li></ul>
						   			
						   			
						   			<ul class="m-menu__subnav"><li class="m-menu__item  m-menu__item--parent" aria-haspopup="true"></li><li class="m-menu__item  m-menu__item--active" aria-haspopup="true"><a href="{{route('subagencylist')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Sub-Agent List</span></a></li></ul></div></li>
						   			
						   			<li class="m-menu__item  m-menu__item--submenu " aria-haspopup="true" m-menu-submenu-toggle="hover"><a href="javascript:;" class="m-menu__link m-menu__toggle"><i class="m-menu__link-icon fas fa-users"></i><span class="m-menu__link-text">User</span><i class="m-menu__ver-arrow fas fa-angle-right"></i></a><div class="m-menu__submenu "><span class="m-menu__arrow"></span>
						   				<ul class="m-menu__subnav"><li class="m-menu__item  m-menu__item--parent" aria-haspopup="true"></li><li class="m-menu__item  m-menu__item--active" aria-haspopup="true"><a href="{{route('user')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Create User</span></a></li></ul>
						   				<ul class="m-menu__subnav"><li class="m-menu__item  m-menu__item--parent" aria-haspopup="true"></li><li class="m-menu__item  m-menu__item--active" aria-haspopup="true"><a href="{{route('userlist')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">User List</span></a></li></ul></div></li>
                                        
                                        
                                        <li class="m-menu__item  m-menu__item--submenu " aria-haspopup="true" m-menu-submenu-toggle="hover"><a href="javascript:;" class="m-menu__link m-menu__toggle"><i class="m-menu__link-icon fas fa-user"></i><span class="m-menu__link-text">Booking Report</span><i class="m-menu__ver-arrow fas fa-angle-right"></i></a>
						   	            <!-- <div class="m-menu__submenu "><span class="m-menu__arrow"></span><ul class="m-menu__subnav"><li class="m-menu__item  m-menu__item--parent" aria-haspopup="true"></li><li class="m-menu__item  m-menu__item--active" aria-haspopup="true"><a href="{{route('agencyBookingdetails')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Voucher Booking</span></a></li></ul></div>-->
						   	             <div class="m-menu__submenu "><span class="m-menu__arrow"></span><ul class="m-menu__subnav"><li class="m-menu__item  m-menu__item--parent" aria-haspopup="true"></li><li class="m-menu__item  m-menu__item--active" aria-haspopup="true"><a href="{{route('agencyUnBookingdetails')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Booking Report</span></a></li></ul></div>
                                       <div class="m-menu__submenu "><span class="m-menu__arrow"></span><ul class="m-menu__subnav"><li class="m-menu__item  m-menu__item--parent" aria-haspopup="true"></li><li class="m-menu__item  m-menu__item--active" aria-haspopup="true"><a href="{{route('cancelledbooking')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Cancelled Booking</span></a></li></ul></div>
                                       <div class="m-menu__submenu "><span class="m-menu__arrow"></span><ul class="m-menu__subnav"><li class="m-menu__item  m-menu__item--parent" aria-haspopup="true"></li><li class="m-menu__item  m-menu__item--active" aria-haspopup="true"><a href="{{route('agentinvoicebooking')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Index</span></a></li></ul></div>
						   	
						   </li>
                           
                             <li class="m-menu__item  m-menu__item--submenu " aria-haspopup="true" m-menu-submenu-toggle="hover"><a href="javascript:;" class="m-menu__link m-menu__toggle"><i class="m-menu__link-icon fas fa-user"></i><span class="m-menu__link-text">Hotel Search</span><i class="m-menu__ver-arrow fas fa-angle-right"></i></a>
						   	  <div class="m-menu__submenu "><span class="m-menu__arrow"></span><ul class="m-menu__subnav"><li class="m-menu__item  m-menu__item--parent" aria-haspopup="true"></li><li class="m-menu__item  m-menu__item--active" aria-haspopup="true"><a href="{{route('hotelsearch')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Hotel Search</span></a></li></ul></div>
						   	  
						   	
						   </li>
                           
                           
                      
                           
                           
                           
                           
                          <!--  <li class="m-menu__item  m-menu__item--submenu " aria-haspopup="true" m-menu-submenu-toggle="hover"><a href="javascript:;" class="m-menu__link m-menu__toggle"><i class="m-menu__link-icon fas fa-user"></i><span class="m-menu__link-text">Notifications</span><i class="m-menu__ver-arrow fas fa-angle-right"></i></a>
						   	             <div class="m-menu__submenu "><span class="m-menu__arrow"></span><ul class="m-menu__subnav"><li class="m-menu__item  m-menu__item--parent" aria-haspopup="true"></li><li class="m-menu__item  m-menu__item--active" aria-haspopup="true"><a href="{{route('notification')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Agents
                                         <?php if(count($notification_badge)) { ?>
                                <span class="m-menu__link-badge"><span class="m-badge m-badge--danger">{{count($notification_badge)}}</span></span>
                                <?php } ?>
                                         
                                         </span></a></li></ul></div>
						   	             
						   </li>-->
                           
                           
                                                        
						   			<?php } if(Auth::user()->user_type == 'SubAgencyManger') { ?>
                                     <li class="m-menu__item  m-menu__item--submenu " aria-haspopup="true" m-menu-submenu-toggle="hover"><a href="javascript:;" class="m-menu__link m-menu__toggle"><i class="m-menu__link-icon fas fa-user"></i><span class="m-menu__link-text">Booking Report</span><i class="m-menu__ver-arrow fas fa-angle-right"></i></a>
						   	            <!-- <div class="m-menu__submenu "><span class="m-menu__arrow"></span><ul class="m-menu__subnav"><li class="m-menu__item  m-menu__item--parent" aria-haspopup="true"></li><li class="m-menu__item  m-menu__item--active" aria-haspopup="true"><a href="{{route('agencyBookingdetails')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Voucher Booking</span></a></li></ul></div>-->
						   	             <div class="m-menu__submenu "><span class="m-menu__arrow"></span><ul class="m-menu__subnav"><li class="m-menu__item  m-menu__item--parent" aria-haspopup="true"></li><li class="m-menu__item  m-menu__item--active" aria-haspopup="true"><a href="{{route('agencyUnBookingdetails')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Booking Report</span></a></li></ul></div>
                                       <div class="m-menu__submenu "><span class="m-menu__arrow"></span><ul class="m-menu__subnav"><li class="m-menu__item  m-menu__item--parent" aria-haspopup="true"></li><li class="m-menu__item  m-menu__item--active" aria-haspopup="true"><a href="{{route('agencyCancellaedBookdetails')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Cancelled Booking</span></a></li>
                                        
                                        
                                       
                                       
                                       </ul></div>
                                       
                                       
                                        <li class="m-menu__item  m-menu__item--submenu " aria-haspopup="true" m-menu-submenu-toggle="hover"><a href="javascript:;" class="m-menu__link m-menu__toggle"><i class="m-menu__link-icon fas fa-user"></i><span class="m-menu__link-text">Hotel Search</span><i class="m-menu__ver-arrow fas fa-angle-right"></i></a>
						   	         <div class="m-menu__submenu "><span class="m-menu__arrow"></span><ul class="m-menu__subnav"><li class="m-menu__item  m-menu__item--parent" aria-haspopup="true"></li><li class="m-menu__item  m-menu__item--active" aria-haspopup="true"><a href="{{route('hotelsearch')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Hotel Search</span></a></li></ul></div>
						          </li>
                                    
                                    <?php } if(Auth::user()->user_type == 'UserInfo') { 
									     
										 if($Premissions['premission'][0]->book == 1){
									
									?>
                                     <li class="m-menu__item  m-menu__item--submenu " aria-haspopup="true" m-menu-submenu-toggle="hover"><a href="javascript:;" class="m-menu__link m-menu__toggle"><i class="m-menu__link-icon fas fa-user"></i><span class="m-menu__link-text">Booking Report</span><i class="m-menu__ver-arrow fas fa-angle-right"></i></a>
						   	             <!--<div class="m-menu__submenu "><span class="m-menu__arrow"></span><ul class="m-menu__subnav"><li class="m-menu__item  m-menu__item--parent" aria-haspopup="true"></li><li class="m-menu__item  m-menu__item--active" aria-haspopup="true"><a href="{{route('agencyBookingdetails')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Voucher Booking</span></a></li></ul></div>-->
						   	             <div class="m-menu__submenu "><span class="m-menu__arrow"></span><ul class="m-menu__subnav"><li class="m-menu__item  m-menu__item--parent" aria-haspopup="true"></li><li class="m-menu__item  m-menu__item--active" aria-haspopup="true"><a href="{{route('agencyUnBookingdetails')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Booking Report</span></a></li></ul></div>
                                        <div class="m-menu__submenu "><span class="m-menu__arrow"></span><ul class="m-menu__subnav"><li class="m-menu__item  m-menu__item--parent" aria-haspopup="true"></li><li class="m-menu__item  m-menu__item--active" aria-haspopup="true"><a href="{{route('agencyCancellaedBookdetails')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Cancelled Booking</span></a></li></ul></div>
                                    
                                    
                                    <li class="m-menu__item  m-menu__item--submenu " aria-haspopup="true" m-menu-submenu-toggle="hover"><a href="javascript:;" class="m-menu__link m-menu__toggle"><i class="m-menu__link-icon fas fa-user"></i><span class="m-menu__link-text">Hotel Search</span><i class="m-menu__ver-arrow fas fa-angle-right"></i></a>
						   	         <div class="m-menu__submenu "><span class="m-menu__arrow"></span><ul class="m-menu__subnav"><li class="m-menu__item  m-menu__item--parent" aria-haspopup="true"></li><li class="m-menu__item  m-menu__item--active" aria-haspopup="true"><a href="{{route('hotelsearch')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Hotel Search</span></a></li></ul></div>
						          </li>
                                    
                                    <?php } } ?>
						   			
						   			<?php if(Auth::user()->user_type == 'UserInfo') { if($Premissions['premission'][0]->agency_list == 1){ ?>
						   				<li class="m-menu__item  m-menu__item--submenu " aria-haspopup="true" m-menu-submenu-toggle="hover"><a href="javascript:;" class="m-menu__link m-menu__toggle"><i class="m-menu__link-icon fas fa-user"></i><span class="m-menu__link-text">Agency</span><i class="m-menu__ver-arrow fas fa-angle-right"></i></a><div class="m-menu__submenu "><span class="m-menu__arrow"></span><ul class="m-menu__subnav"><li class="m-menu__item  m-menu__item--parent" aria-haspopup="true"></li><li class="m-menu__item  m-menu__item--active" aria-haspopup="true"><a href="{{route('agencylist')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Agent List</span></a></li></ul></div></li>                
						   			<?php } else if($Premissions['premission'][0]->agency_open == 1) { ?> 
						   				
						   				<li class="m-menu__item  m-menu__item--submenu " aria-haspopup="true" m-menu-submenu-toggle="hover"><a href="javascript:;" class="m-menu__link m-menu__toggle"><i class="m-menu__link-icon fas fa-user"></i><span class="m-menu__link-text">Agency</span><i class="m-menu__ver-arrow fas fa-angle-right"></i></a><div class="m-menu__submenu "><span class="m-menu__arrow"></span><ul class="m-menu__subnav"><li class="m-menu__item  m-menu__item--parent" aria-haspopup="true"></li><li class="m-menu__item  m-menu__item--active" aria-haspopup="true"><a href="{{route('agency')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Agent List</span></a></li></ul></div></li>
                                      <?php if($Premissions['premission'][0]->agency_open == 1) {?>
                                      <li class="m-menu__item  m-menu__item--submenu " aria-haspopup="true" m-menu-submenu-toggle="hover"><a href="javascript:;" class="m-menu__link m-menu__toggle"><i class="m-menu__link-icon fas fa-user"></i><span class="m-menu__link-text">Agency</span><i class="m-menu__ver-arrow fas fa-angle-right"></i></a><div class="m-menu__submenu "><span class="m-menu__arrow"></span><ul class="m-menu__subnav"><li class="m-menu__item  m-menu__item--parent" aria-haspopup="true"></li><li class="m-menu__item  m-menu__item--active" aria-haspopup="true"><a href="{{route('agency')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Create Agent</span></a></li></ul></div></li>
									  
									  
									  <?php }     ?>  
                                        
                                        
						   			<?php  } ?>
									
									
									<?php if($Premissions['premission'][0]->user_list == 1){ ?> 
						   				
						   				<li class="m-menu__item  m-menu__item--submenu " aria-haspopup="true" m-menu-submenu-toggle="hover"><a href="javascript:;" class="m-menu__link m-menu__toggle"><i class="m-menu__link-icon fas fa-users"></i><span class="m-menu__link-text">User</span><i class="m-menu__ver-arrow fas fa-angle-right"></i></a><div class="m-menu__submenu "><span class="m-menu__arrow"></span><ul class="m-menu__subnav"><li class="m-menu__item  m-menu__item--parent" aria-haspopup="true"></li><li class="m-menu__item  m-menu__item--active" aria-haspopup="true"><a href="{{route('userlist')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">User List</span></a></li></ul></div></li> 
						   			<?php  } else if($Premissions['premission'][0]->user_create == 1) { ?> 
						   				<li class="m-menu__item  m-menu__item--submenu " aria-haspopup="true" m-menu-submenu-toggle="hover"><a href="javascript:;" class="m-menu__link m-menu__toggle"><i class="m-menu__link-icon fas fa-users"></i><span class="m-menu__link-text">User</span><i class="m-menu__ver-arrow fas fa-angle-right"></i></a><div class="m-menu__submenu "><span class="m-menu__arrow"></span><ul class="m-menu__subnav"><li class="m-menu__item  m-menu__item--parent" aria-haspopup="true"></li><li class="m-menu__item  m-menu__item--active" aria-haspopup="true"><a href="{{route('user')}}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">User</span></a></li></ul></div></li> 
						   				
						   			<?php } }?>
						   			<?php  if(Auth::user()->user_type != 'SuperAdmin'){ ?>

						   				
						   				<li class="m-menu__item  m-menu__item--submenu " aria-haspopup="true" m-menu-submenu-toggle="hover"><a href="{{route('profile')}}" class="m-menu__link m-menu__toggle"><i class="m-menu__link-icon fas fa-user"></i><span class="m-menu__link-text">Profile</span><i class="m-menu__ver-arrow fas fa-angle-right"></i></a>
						   					
						   					

						   				<?php } ?>

						   			</ul>
						   		</div>
						   		<!-- END: Aside Menu -->
						   	</div>
                            <div class="m-grid__item m-grid__item--fluid m-wrapper">
	<!-- BEGIN: Subheader -->
	<div class="m-subheader ">
		<div class="d-flex align-items-center">
			<div class="mr-auto">
				<h3 class="m-subheader__title ">
                
                <?php 
				
			/*	echo 'g;hlf;dlh;flg;lhdf;glh';
				echo '<br/>';
				echo $pagename;
				echo '<br/>';*/
				
				?>
                
                <?php if($pagename == 'agencyCancelledBookingList') {?>
					Cancelled Booking
                    <!--<a class="create-content" href="http://23.229.195.196/test/public/rolelist">Role List</a>-->
                    <?php } ?>
                
                  <?php if($pagename == '@index') {?>
					Dashboard
                    <!--<a class="create-content" href="http://23.229.195.196/test/public/rolelist">Role List</a>-->
                    <?php } ?>
                    
                    
                    <?php if($pagename == '@homeSearch') {?>
					Search Hotel
                    <!--<a class="create-content" href="http://23.229.195.196/test/public/rolelist">Role List</a>-->
                    <?php } ?>
                    
                    <?php if($pagename == 'agencylist') {?>
					Agencies List
                    <!--<a class="create-content" href="http://23.229.195.196/test/public/rolelist">Role List</a>-->
                    <a class="create-content" href="{{route('agency')}}">Create Agency</a>
                    <?php } ?>
                    
                    
                    <?php if($pagename == 'subagencylist') {?>
					   
                     Sub Agency List
                    <!--<a class="create-content" href="http://23.229.195.196/test/public/rolelist">Role List</a>-->
                    <a class="create-content" href="{{route('agency')}}">Create Sub Agency</a>
                    <?php } ?>
                    
                    <?php if($pagename == 'agencyBookingList') {?>
					   
                    Voucher Booking Report
                    <!--<a class="create-content" href="http://23.229.195.196/test/public/rolelist">Role List</a>-->
                   
                    <?php } ?>
                    
                    
                    <?php if($pagename == '@adminemailc') {?>
					   
                    Email Setting
                    <!--<a class="create-content" href="http://23.229.195.196/test/public/rolelist">Role List</a>-->
                   
                    <?php } ?>
                    
                    
                    <?php if($pagename == 'agencyUnBookingList') {?>
					   
                   Booking Report
                    <!--<a class="create-content" href="http://23.229.195.196/test/public/rolelist">Role List</a>-->
                   
                    <?php } ?>
                    
                    <?php if($pagename == 'viewagency') {?>
					   
                    Agency Information
                    <!--<a class="create-content" href="http://23.229.195.196/test/public/rolelist">Role List</a>-->
                   
                    <?php } ?>
                    
                    
                    <?php if($pagename == 'user') {?>
					   
                    Create New User
                    <a class="create-content" href="{{route('userlist')}}">User List</a>
                    <!--<a class="create-content" href="http://23.229.195.196/test/public/rolelist">Role List</a>-->
                   
                    <?php } ?>
                    
                    
                    <?php if($pagename == 'userlist') {?>
					   
                    User List
                    <a class="create-content" href="{{route('user')}}">Create New User</a>
                    <!--<a class="create-content" href="http://23.229.195.196/test/public/rolelist">Role List</a>-->
                   
                    <?php } ?>
                    
                    <?php if($pagename == 'userupdate') {?>
					   
                    Update User
                    <a class="create-content" href="{{route('userlist')}}">User List</a>
                    <!--<a class="create-content" href="http://23.229.195.196/test/public/rolelist">Role List</a>-->
                   
                    <?php } ?>
                    
                    
                    
                    
                     <?php if($pagename == 'vouchecdbooking') {?>
					   
                    Voucher Booking Report
                    
                     
                    <!--<a class="create-content" href="http://23.229.195.196/test/public/rolelist">Role List</a>-->
                   
                    <?php } ?>
                    
                    
                    <?php if($pagename == 'unvouchecdbooking') {?>
					   
                    Booking Report
                    
                     
                    <!--<a class="create-content" href="http://23.229.195.196/test/public/rolelist">Role List</a>-->
                   
                    <?php } ?>
                    
                    
                     <?php if($pagename == 'agencyddetailbookingreport') {?>
					   
                   Invoice
                    
                     
                    <!--<a class="create-content" href="http://23.229.195.196/test/public/rolelist">Role List</a>-->
                   
                    <?php } ?>
                    
                    
                    <?php if($pagename == 'agentbooking') {?>
					   
                    Agent Wise Booking Report
                    
                     
                    <!--<a class="create-content" href="http://23.229.195.196/test/public/rolelist">Role List</a>-->
                   
                    <?php } ?>
                    
                    <?php if($pagename == 'admininvoicebooking' || $pagename == 'agentinvoicebooking') {?>
					   
                    Invoice Booking Report
                    
                     
                    <!--<a class="create-content" href="http://23.229.195.196/test/public/rolelist">Role List</a>-->
                   
                    <?php } ?>
                    
                    
                    
                    
                    <?php if($pagename == 'cancelledbooking') {?>
					   
                    Cancelled Booking Report
                    
                     
                    <!--<a class="create-content" href="http://23.229.195.196/test/public/rolelist">Role List</a>-->
                   
                    <?php } ?>
                    
                    
                    <?php if($pagename == 'role') {?>
					   
                   Create New User
                    
                     <a class="create-content" href="{{route('rolelist')}}">Role List</a>
                    <!--<a class="create-content" href="http://23.229.195.196/test/public/rolelist">Role List</a>-->
                   
                    <?php } ?>
                    
                    
                    <?php if($pagename == 'rolelist') {?>
					   
                   User Role List 
           
                     <a class="create-content" href="{{route('role')}}">Create Role</a>
                    <!--<a class="create-content" href="http://23.229.195.196/test/public/rolelist">Role List</a>-->
                   
                    <?php } ?>
                    
                    <?php if($pagename == 'profile') {?>
					   
                        Edit Profile
           
                    <!--<a class="create-content" href="http://23.229.195.196/test/public/rolelist">Role List</a>-->
                   
                    <?php } ?>
                    
                     <?php if($pagename == 'adminApicontrol') {?>
					   
                       Admin Portal
           
                    <!--<a class="create-content" href="http://23.229.195.196/test/public/rolelist">Role List</a>-->
                   
                    <?php } ?>
                    
                    
                     <?php if($pagename == 'agentbookingwise') {?>
					   
                       Agent wise Booking Report
           
                    <!--<a class="create-content" href="http://23.229.195.196/test/public/rolelist">Role List</a>-->
                   
                    <?php } ?>
                    
                    
                    
                    
                    
                    
       
                    <?php 
					if(Auth::user()->user_type == 'AgencyManger'){
					
					if($pagename == 'agency') {?>
					Create Sub Agency
                    <!--<a class="create-content" href="http://23.229.195.196/test/public/rolelist">Role List</a>-->
                    <a class="create-content" href="{{route('subagencylist')}}">Sub Agency List</a>
                    <?php } } else { if($pagename == 'agency') {?> 
                    Create Agency
                    
                    <a class="create-content" href="{{route('agencylist')}}" class="m-form">Agency List</a>
                    
                    <?php }} ?>
                    
                    
                    
				</h3>
			</div>
            <div id="m_header_topbar" class="m-topbar m-topbar-altemob  m-stack m-stack--ver m-stack--general">
								<div class="m-stack__item m-topbar__nav-wrapper">
									<ul class="m-topbar__nav m-nav m-nav--inline">
										
										<li class="m-nav__item m-topbar__notifications m-topbar__notifications--img m-dropdown m-dropdown--large m-dropdown--header-bg-fill m-dropdown--arrow m-dropdown--align-center 	m-dropdown--mobile-full-width" m-dropdown-toggle="click" m-dropdown-persistent="1">
											<a href="#" class="m-nav__link m-dropdown__toggle" id="m_topbar_notification_icon">
												<span class="m-nav__link-badge m-badge m-badge--dot m-badge--dot-small m-badge--danger"></span>
												<span class="m-nav__link-icon">
													<i class="flaticon-music-2"></i>
												</span>
											</a>
											<div class="m-dropdown__wrapper m-dropdown__wrappernotofialter">
												<span class="m-dropdown__arrow m-dropdown__arrow--center  down__arrow--centeralter"></span>
												<div class="m-dropdown__inner">
													<div class="m-dropdown__header m--align-center" style="background: url(http://23.229.195.196/test/public/img/notification_bg.jpg); background-size: cover;">
														<span class="m-dropdown__header-title">
															New
														</span>
														<span class="m-dropdown__header-subtitle">
															 Notifications
														</span>
													</div>
													<div class="m-dropdown__body">				
				<div class="m-dropdown__content">
					<ul class="nav nav-tabs m-tabs m-tabs-line m-tabs-line--brand" role="tablist">
						<li class="nav-item m-tabs__item">
							<a class="nav-link m-tabs__link active show" data-toggle="tab" href="#topbar_notifications_notifications" role="tab" aria-selected="true">
							Agency
							</a>
						</li>
						<li class="nav-item m-tabs__item">
							<a class="nav-link m-tabs__link" data-toggle="tab" href="#topbar_notifications_events" role="tab" aria-selected="false">User</a>
						</li>
						<li class="nav-item m-tabs__item">
							<a class="nav-link m-tabs__link" data-toggle="tab" href="#topbar_notifications_logs" role="tab" aria-selected="false">Logs</a>
						</li>
					</ul>
					<div class="tab-content">
						<div class="tab-pane active show" id="topbar_notifications_notifications" role="tabpanel">
							<div class="m-scrollable m-scroller ps ps--active-y" data-scrollable="true" data-height="250" data-mobile-height="200" style="height: 250px; overflow: hidden;">
								<div class="m-list-timeline m-list-timeline--skin-light">
									<div class="m-list-timeline__items">
										
                                                                                
                                                <?php 
																			
										if(isset($agecnyresultsnotificationread[0])){ 
																			
											foreach($agecnyresultsnotificationread as $agecnyresultsnotificationread_value){
																			?>
										<div class="m-list-timeline__item">
											<span class="m-list-timeline__badge"></span>
											<span class="m-list-timeline__text">{{$agecnyresultsnotificationread_value->name}}(<?php if($agecnyresultsnotificationread_value->parentagencyid == '0'){ echo 'Agency'; }else{ echo 'SubAgency'; } ?>)<span class="m-badge m-badge--success m-badge--wide">New Agency</span></span>
											<span class="m-list-timeline__time"></span>
										</div>
										<?php } } ?>
                                        
                                        <?php 
																			
										if(isset($agecnyresultsnotification[0])){ 
																			
										foreach($agecnyresultsnotification as $agecnyresults_notification_value){
																			?>
										<div class="m-list-timeline__item">
											<span class="m-list-timeline__badge"></span>
											<span class="m-list-timeline__text"> {{$agecnyresults_notification_value->name}}(<?php if($agecnyresults_notification_value->parentagencyid == '0'){ echo 'Agency'; }else{ echo 'SubAgency'; } ?>)<span class="m-badge m-badge--success m-badge--wide">Updated</span><span class="icons-faiocns fa fa-info updateinfo" data-id="{{$agecnyresults_notification_value->id}}" data-role="agency"></span></span>
											<span class="m-list-timeline__time"></span>
										</div>
										<?php } } ?>
                                        
                                        
									</div>
								</div>
							</div>
						</div>
						<div class="tab-pane" id="topbar_notifications_events" role="tabpanel">
							<div class="m-scrollable m-scroller ps" data-scrollable="true" data-height="250" data-mobile-height="200" style="height: 250px; overflow: hidden;">
								<div class="m-list-timeline m-list-timeline--skin-light">
									<div class="m-list-timeline__items">
										

                             <?php 
																			
										if(isset($userresultsnotification[0]) || isset($userresultsnotificationread[0])){ 
																			
									 foreach($userresultsnotification as $userresultsnotification_value){
																			?>
										<div class="m-list-timeline__item">
											<span class="m-list-timeline__badge"></span>
											<span class="m-list-timeline__text"><a href="{{route('userupdate')}}?id={{Crypt::encrypt(base64_encode($userresultsnotification_value->id))}}&read=1" class="m-list-timeline__text">{{$userresultsnotification_value->name}}</a> <span class="m-badge m-badge--success m-badge--wide">Updated</span><span class="icons-faiocns fa fa-info updateinfo" data-id="{{$userresultsnotification_value->id}}" data-role="user"></span></span>
											<span class="m-list-timeline__time"></span>
										</div>
										<?php } } ?>
                                        
                                    
									</div>
								</div>
							</div>
						</div>
						<div class="tab-pane" id="topbar_notifications_logs" role="tabpanel">
							<div class="m-scrollable m-scroller ps" data-scrollable="true" data-height="250" data-mobile-height="200" style="height: 250px; overflow: hidden;">
								<div class="m-list-timeline m-list-timeline--skin-light">
									<div class="m-list-timeline__items">
										<div class="m-list-timeline__item">
											<span class="m-list-timeline__badge -m-list-timeline__badge--state-success"></span>
											<span class="m-list-timeline__text"></span>
											<span class="m-list-timeline__time"></span>
										</div>
                                        
                               
                                                                                
                                                                                <?php 
																			
										if(isset($whologin[0])){ 
																			
																			   foreach($whologin as $whologin_value){
																				   if(isset($activeDetails[$whologin_value->loginid])){
																			?>
										<div class="m-list-timeline__item">
											<span class="m-list-timeline__badge"></span>
											<span class="m-list-timeline__text"><?php 
																						
																							
																						      echo $activeDetails[$whologin_value->loginid]['name'];
																						
																						
																						
																						?> ({{$whologin_value->type}}) <span class="m-badge m-badge--success m-badge--wide">Active</span></span>
											<span class="m-list-timeline__time"></span>
										</div>
										<?php } } } ?>
                                        
                                    
									</div>
								</div>
							</div>
					</div>
				</div>
			</div>
												</div>
											</div>
										</li>
                                        
                                        <li class="m-nav__item m-topbar__user-profile m-topbar__user-profile--img  m-dropdown m-dropdown--medium m-dropdown--arrow m-dropdown--header-bg-fill m-dropdown--align-right m-dropdown--mobile-full-width m-dropdown--skin-light" m-dropdown-toggle="click">
											<a href="#" class="m-nav__link m-dropdown__toggle">
												<span class="m-topbar__userpic">
                                              
													<img src="{{asset('/img/user4c.png')}}" class="m--img-rounded m--marginless m--img-centered" alt=""/>
												</span>
												<span class="m-topbar__username m--hide">
													Nick
												</span>
											</a>
											<div class="m-dropdown__wrapper m-dropdown__wrapper-profilealt">
												<span class="m-dropdown__arrow m-dropdown__arrow--right m-dropdown__arrow--adjust"></span>
												<div class="m-dropdown__inner">                        
													<div class="m-dropdown__header m--align-center" style="background: url(http://23.229.195.196/test/public/img/user_profile_bg.jpg); background-size: cover;">
														<div class="m-card-user m-card-user--skin-dark">
															<div class="m-card-user__pic">
																<img src="{{asset('/img/user4c.png')}}" class="m--img-rounded m--marginless" alt=""/>
															</div>
															<div class="m-card-user__details">
																<span class="m-card-user__name m--font-weight-500">
																	<?php if(Auth::user()->user_type == 'UserInfo') { ?> {{Auth::user()->name}} <?php } ?><?php if(Auth::user()->user_type == 'AgencyManger') { ?> {{$agencylistm[0]->aname}} <?php } ?><?php if(Auth::user()->user_type == 'SuperAdmin') { ?> Super Admin <?php } ?>
																</span>
																<!--<a href="" class="m-card-user__email m--font-weight-300 m-link">
																	mark.andre@gmail.com
																</a>-->
															</div>
														</div>
													</div>
													<div class="m-dropdown__body">
														<div class="m-dropdown__content">
															<ul class="m-nav m-nav--skin-light">
																<li class="m-nav__section m--hide">
																	<span class="m-nav__section-text">
																		Section
																	</span>
																</li>
                                                                <?php  if(Auth::user()->user_type != 'SuperAdmin'){ ?>
																<li class="m-nav__item">
																	<a href="{{route('profile')}}" class="m-nav__link">
																		<i class="m-nav__link-icon flaticon-profile-1"></i>
																		<span class="m-nav__link-title">
																			<span class="m-nav__link-wrap">
																				<span class="m-nav__link-text">
																					My Profile
																				</span>
																				<!--<span class="m-nav__link-badge">
																					<span class="m-badge m-badge--success">
																						2
																					</span>
																				</span>-->
																			</span>
																		</span>
																	</a>
																</li>
                                                                <?php } ?>
																<!--<li class="m-nav__item">
																	<a href="header/profile.html" class="m-nav__link">
																		<i class="m-nav__link-icon flaticon-share"></i>
																		<span class="m-nav__link-text">
																			Activity
																		</span>
																	</a>
																</li> -->
																
																<li class="m-nav__separator m-nav__separator--fit"></li>
																<!--<li class="m-nav__item">
																	<a href="header/profile.html" class="m-nav__link">
																		<i class="m-nav__link-icon flaticon-info"></i>
																		<span class="m-nav__link-text">
																			FAQ
																		</span>
																	</a>
																</li>
																<li class="m-nav__item">
																	<a href="header/profile.html" class="m-nav__link">
																		<i class="m-nav__link-icon flaticon-lifebuoy"></i>
																		<span class="m-nav__link-text">
																			Support
																		</span>
																	</a>
																</li>-->
																<li class="m-nav__separator m-nav__separator--fit"></li>
																<li class="m-nav__item">
																	
                                                                    
                                                                    <a href="javascript:void(0);" class="logoutc btn m-btn--pill    btn-secondary m-btn m-btn--custom m-btn--label-brand m-btn--bolder" title="Logout">Logout
                        <input type="hidden" value="{{ route('logout') }}" id="logout_url"/>
                        
                        <input type="hidden" value="{{ url('/') }}" id="home_url"/>
                        <input type="hidden" value="{{ Auth::user()->id }}" id="logout_id"/>
						<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
							<input type="hidden" name="_token" value="<?php echo @csrf_token(); ?>">
						</form>
                        
                        <form id="logoutformnew" action="{{ route('whologin') }}" method="POST" style="display: none;">
                           <input type="hidden" name="_token" value="<?php echo @csrf_token(); ?>">
                           <input type="hidden" value="{{ route('logout') }}" id="logout_url"/>
                            <input type="hidden" value="{{ Auth::user()->id }}" id="loginid" name="loginid"/>
                        </form>
					</a> 
                                                                    
																</li>
															</ul>
														</div>
													</div>
												</div>
											</div>
										</li>
                                        
                                        
									</ul>
								</div>
							</div>
		</div>
	</div>
	<!-- END: Subheader -->
