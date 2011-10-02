<?php
// Initialize a session.
session_start();
include("./include/config.inc.php");
		$do=$_GET['do'];
		if($do=="check") {
					$u=$_POST['user'];
					$p=$_POST['pass'];
					$Conn = ocilogon($dbuser, $dbpass, $hostname, $encode);
					if (!$Conn) {
					echo "An error has occured connecting to the database";
					exit;
					}
	
					$query = "SELECT * FROM EMPLOYEE WHERE EMP_ID='".$u."' and EMP_PASS='".$p."'";
					$result = OCIParse($Conn, $query);
					if(! $result) {
					echo "An error occurred in parsing the sql string '$query'.\n";
					exit;
					}
					$r = OCIExecute($result);
					if(! $r) {
					echo "An error occurred in executing the sql '$query'.\n";
					exit;
					}

					$count = oci_fetch($result);
					if ($count == 1) {
					
							$_SESSION['logged_in']=session_id();
 							//$_SESSION['first_name'] = $row[1];
							//$_SESSION['userid'] = $row[0];
							$_SESSION['first_name'] = oci_result($result, 'EMP_NAME');
							$_SESSION['userid'] = oci_result($result, 'EMP_ID');
							$_SESSION['LOC_ID'] = oci_result($result, 'LOC_ID');
 							header("Location: $main_page");
 							oci_free_statement($result);
							oci_close($Conn);
					} else {
					//������١��ͧ����Ѻ�˹�� Login
   				//echo "<h1><a href=\"$login_page\">Error : Username ���� Password ���١��ͧ...�ͧ����</a></h1>";
   				echo "<meta http-equiv=\"refresh\" content=\"0;url=$login_page?msg=1\" />";
   				/*
   				//debug	
   				echo $count;
   				echo $u;
   				echo $p;
   				*/
   				oci_free_statement($result);
				oci_close($Conn);
				exit();
				}
			}	elseif ($do=="logout") {
					session_destroy();
					//echo "<h1></h1><br />";
					//header("Location: $main");
					//echo "<a href=\"$main_page\"><h2>Go to the main page</h2></a>";
					echo "<meta http-equiv=\"refresh\" content=\"0;url=$login_page?msg=2\" />";
				}
?>

<!DOCTYPE html> 
<html lang="en" class="no-js">
<head>
    <title>เข้าสู่ระบบ</title>
    
    <!-- // Meta //  -->
    <meta charset="utf-8">   
    <meta name="description" content="" />
    <meta name="keywords" content="" />
    <!--[if IE]>
    <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7">
    <![endif]-->
    
    <!-- // Stylesheets // -->
    <link rel="stylesheet" href="css/login.css" />

    <!-- http://allinthehead.com/retro/319/how-to-set-an-apple-touch-icon-for-any-site -->
    <link rel="apple-touch-icon" href="images/apple-touch-icon.png">
    <link rel="shortcut icon" href="images/favicon.ico">
        
    <!-- All JavaScript at the bottom, except for Modernizr which enables HTML5 elements & feature detects -->
    <script src="js/modernizr-1.7.min.js"></script>
    
</head>
<body>
    <div id="container">
        <form action="login.php?do=check" method="post"> 
            <div id="login-box" class="corners shadow">
                <div class="login-box-header corners">
                    <h2>กรุณาเข้าสู่ระบบ</h2>
                </div>
				<?php 
				if (isset($_GET['msg']) && $_GET['msg'] == 1) {
		echo "<div class=\"login-box-error-small corners\"><p>เกิดข้อผิดพลาด:  username หรือ password ผิด!</p></div>"; 
		}
		if (isset($_GET['msg']) && $_GET['msg'] == 2) {
		echo "<div class=\"login-box-error-small corners\"><p>คุณได้ออกจากระบบแล้ว!</p></div>"; 
		}
		?>

                <div class="login-box-row-wrap corners">
                    <label for="username">Username:</label><input type="text" id="username" value="" name="user" class="input-1"/>
                </div>
                <div class="login-box-row-wrap corners">
                    <div>
                        <label for="password">Password:</label><input type="password" id="password" value="" name="pass" class="input-1 password"/>
                    </div>    
                    <!--<a href="#" class="rmb">Forgot password</a>-->
                </div>
                <div class="login-box-row corners">
                   <!--<input type="checkbox" name="" id="field-remember"/> <label for="field-remember">Remember me on this computer?</label>-->
                    <input type="submit" name="" value="Login" id="submit"/>
                </div>
                <div class="loader corners"></div>
            </div>
        </form>
    </div><!-- END "#container" -->
        
    <!-- // Javascript/jQuery // -->
	<script src="js/jquery-1.6.min.js"></script>
    <script src="js/showpassword.js"></script>
    <script src="js/login.js"></script>
    

        
</body>
</html>