<!DOCTYPE html> 
<html lang="en" class="no-js">
<head>
    <title>Computer 777 | Welcome</title>
    
    <!-- // Meta //  -->
    <meta charset="utf-8">   
    <meta name="description" content="" />
    <meta name="keywords" content="" />
    <!--[if IE]>
    <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7">
    <![endif]-->
    
    <!-- // Stylesheets // -->
    <link rel="stylesheet" href="css/style1.css" />
    <link rel="stylesheet" type="text/css" href="lightbox/style5/style.css">

    <!-- http://allinthehead.com/retro/319/how-to-set-an-apple-touch-icon-for-any-site -->
    <link rel="apple-touch-icon" href="images/apple-touch-icon.png">
    <link rel="shortcut icon" href="images/favicon.ico">
        
    <!-- All JavaScript at the bottom, except for Modernizr which enables HTML5 elements & feature detects -->
    <script src="js/modernizr-1.7.min.js"></script>
    
</head>
<body>
    <div id="container">
        <header>
            <ul id="user-meta">
                <li>ยินดีต้อนรับ, <img src="images/icons/9/005_13.png" alt="<?=$_SESSION['first_name']?>" /> คุณ  <b><?=$_SESSION['first_name']?></b></li>
                <li>|</li>
                <li><img src="images/icons/9/005_12.png" alt="" /><a href="<?=$logout_page?>" title="ออกจากระบบ">ออกจากระบบ</a></li>
            </ul>        
            <div id="menu-bar" class="corners shadow">
                <div class="menu-bar-inner corners">
                    <a href="index.php" title="" id="logo">
                        <h1>Computer 777 Shop</h1>
                    </a>
                    <ul id="menu">
                        <li class="sep"><a href="index.php" title="">Home</a></li>
                        <li class="sep"><a href="#" title="">About</a></li>
                    </ul>
                    
                    <form action="search.php?do=normal" method="post" id="search">
                        <div>
                        <input type="text" name="txtKeyword" onFocus="if(this.value=='ใส่คำค้นหาที่นี่...')this.value='';" onBlur="if(this.value=='')this.value='ใส่คำค้นหาที่นี่...';" value="ใส่คำค้นหาที่นี่..." id="input-s" />
                        <input type="submit" value="" name="submit" id="search-submit" />
                        </div>
                        <a href="javascript:void(null);" title="" class="close" id="toggle-menu"><!-- --></a>
                    </form>
                </div>
            </div><!-- END "#menu-bar" -->
            
            <ul id="submenu" class="corners shadow">
                <li>    
                    <a href="brance_sum.php" class="icon-menu corners">
                        <img src="images/icons/48/edit-paste.png" alt="" title="" />
                        <span>เรียกดูยอดขายตามวัน</span>
                    </a>
                </li>    
                <li>                      
                    <a href="search.php" class="icon-menu corners">
                        <img src="images/icons/48/x-office-spreadsheet.png" alt="" title="" />
                        <span>ค้นหาสินค้า</span>
                    </a>
                </li>   
                <li>                      
                    <a href="testjquery.php" class="icon-menu corners">
                        <img src="images/icons/48/x-office-presentation.png" alt="" title="" />
                        <span>หน้าขายของ</span>
                    </a>
                </li>           
                 <li>                      
                    <a href="add_main_addform.php" class="icon-menu corners">
                        <img src="images/icons/48/system-help.png" alt="" title="" />
                        <span>เพิ่มของลงคลัง</span>
                    </a>
                </li>    
                <li>                      
                    <a href="update_main.php" class="icon-menu corners">
                        <img src="images/icons/48/x-office-calendar.png" alt="" title="" />
                        <span>อัพเดตคลังสินค้า</span>
                    </a>
                </li>
                 <li>                      
                    <a href="main_sum_bydate.php" class="icon-menu corners">
                        <img src="images/icons/48/user-info.png" alt="" title="" />
                        <span>เรียกดูยอดขาย ตามวันที่</span>
                    </a>
                </li>
                <li>                      
                    <a href="main_sum1.php" class="icon-menu corners">
                        <img src="images/icons/48/utilities-system-monitor.png" alt="" title="" />
                        <span>เรียกดูยอดขายตามวันที่+สาขา</span>
                    </a>
                </li> 
                 <li>                      
                    	<a href="out_stock.php" class="icon-menu corners">
                        <img src="images/icons/48/mail-mark-unread.png" alt="" title="" />
                        <span>เบิกสินค้า</span>
                    </a>
                </li>    
            </ul><!-- END "#submenu" -->
             
            <div id="breadcrumbs" class="corners shadow">
                <p class="left"><img src="images/icons/9/005_08.png" alt="" />หน้าจัดการร้าน Computer 777</p>
                <p class="right"><img src="images/icons/9/005_21.png" alt="" />ขณะนี้เวลา: <?=date('jS D F Y h:i:s A');?></p>
            </div><!-- END "#breadcrumbs" --> 
            <div id="mastertoggle" class="corners shadow">
                <div>
                    <a href="javascript:void(null);" title="Close all boxes" class="togglecloseall corners tip"></a> 
                    <a href="javascript:void(null);" title="Open all boxes" class="toggleopenall corners tip"></a>
                </div>
            </div><!-- END "#mastertoggle" -->  
                                
        </header><!-- END header -->