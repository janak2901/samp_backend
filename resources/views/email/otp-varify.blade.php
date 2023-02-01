<!DOCTYPE html>
<html lang='en'>
<head>
	<meta charset='UTF-8'>
	<meta http-equiv='X-UA-Compatible' content='IE=edge'>
	<meta name='viewport' content='width=device-width, initial-scale=1.0'>
	<title>Document</title>
	
	<style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: system-ui;
        }

        .verify-account {
            padding: 1.75rem;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            /*background: aliceblue;*/
        }

        .logo-image {
            /*width: 380px;*/
            overflow: hidden;
            margin-bottom: 10px;
        }

        .m-b-10 {
            margin-bottom: 10px;
        }

        .logo-image img {
            width: 100%;
        }

        .font-size-h3 {
            font-size: 1rem;
            /*margin-bottom: .5rem;*/
            margin-bottom: 20px;
        }

        .text-code {
            font-size: 2rem;
            font-weight: 700;
            letter-spacing: 2px;
        }

        .verify-code-section {
            text-align: center;
        }

        .resend-otp-wrap {
            margin-top: 1.25rem;
        }

        @media screen and (min-width: 320px) and (max-width: 678px) {
            .logo-image {
                width: 280px;
            }

            .font-size-h3, .text-code {
                font-size: 1.5rem;
            }
        }
	</style>
</head>
<body>
<div class='verify-account'>
	<div class='main-container'>
		<div class='verify-code-section'>
			<div class='logo-image'>
				<img src='{{asset('assets/img/logo.png')}}' style="width: 200px;" alt=''>
			</div>
			<div class='title-wrap' style='margin-bottom: 1rem;'>
				<div class="font-size-h3">Confirm your email address.</div>
				<div class="font-size-h3">Your confirmation code is below - enter it in your open browser window and we'll help you get signed in.</div>
				<div style='margin-bottom: 20px;'>Here is your OTP verification code</div>
				<div class='text-code font-weight-bold' style='margin: auto;padding: 10px;width: 300px;background-color: #eee;'> {{$otp}} </div>
				<div class='font-size-h3' style="margin: 20px auto"> If you didn't request this email, there's nothing to worry about safely ignore it.</div>
			</div>
			<div class='resend-otp-wrap'>
				<div style='color: #ea2323;'>it will expires in 5 minutes</div>
			</div>
			<div class="logo-image">
				<img src='{{asset('assets/img/centroall-logo.png')}}' style="width: 100px;" alt=''>
			</div>
			<div class="title-wrap">
				<div class="font-size-h3">
					Made by Centroall.
				</div>
				<div class="font-size-h3">
					501-502, Velocity Business Hub NR. Madhuvan Circle, LP Savani Rd, Adajan Gam, Surat, Gujarat - 395009
				</div>
				<a style="text-decoration: none;" href="https://www.centroall.com">centroall.com</a>
			</div>
		</div>
	</div>
</div>

</body>
</html>


<!DOCTYPE html>
<html lang='en'>
<head>
	<meta charset='UTF-8'>
	<meta http-equiv='X-UA-Compatible' content='IE=edge'>
	<meta name='viewport' content='width=device-width, initial-scale=1.0'>
	<title>OTP Verification</title>
	<style> @media screen and (min-width: 0) and (max-width: 678px) {
            .logo-image img {
                width: 100px;
            }

            .font-size-h3, .text-code {
                font-size: 14px !important;
            }

            .main-container {
                padding: 50px 30px !important;
            }
        } </style>
</head>
<body style='margin: 0;padding: 0;box-sizing: border-box;font-family: system-ui;'>
<div class='main-container' style='padding: 100px 30px;display: flex;justify-content: center;align-items: center;'>
	<div>
		<div style='text-align: center;'>
			<div style='text-align: left; padding: 0px 0 20px 0;'>
				<div class='logo-image' style='display: flex; align-items: center;'>
					<img src='{{asset('assets/img/logo.png')}}' style='width: 250px;' alt=''></div>
				<div style='margin-bottom: 1rem;'>
					<div class='font-size-h3' style='font-size: 1rem;margin-bottom: 20px;'>
						<h1>Confirm your email address.</h1></div>
					<div class='font-size-h3' style='font-size: 1rem;margin-bottom: 20px;'>
						<p style='color: #363232;'>Your confirmation code is below - enter it in your open browser window and we'll help you get signed in.</p>
					</div>
					<div style='margin-bottom: 20px;'><p style='color: #363232;'>Here is your OTP verification code</p>
					</div>
					<div class='text-code' style='margin: 40px 0 ;padding: 10px;background-color: #eee;border-radius: 8px;font-size: 2rem;font-weight: 700;letter-spacing: 2px;'>
						<p style='margin: 0 ;color: #363232;' align='center'>111111</p></div>
					<div class='font-size-h3' style='font-size: 1rem;margin-bottom: 20px;' style=''>
						<p style='color: #363232;'>If you didn't request this email, there's nothing to worry about safely ignore it.</p>
					</div>
				</div>
				<div style='margin-top: 1.25rem;'>
					<div style='color: #ea2323;'><p>it will expires in 111111 minutes</p></div>
				</div>
			</div>
			<div>
				<div class='logo-image'><img src='{{asset('assets/img/centroall-logo.png')}}' style='width: 100px;' alt=''></div>
				<div class='font-size-h3' style='font-size: 1rem;margin-bottom: 20px;'>
					<h3 style='margin-top: 0;color: rgb(56, 106, 207);'>Centroall</h3>
					<h3 style='margin-top: 10px;color: rgb(56, 106, 207);'>Minimising Time & Efforts</h3>
				</div>
				<div class='font-size-h3' style='font-size: 1rem;margin-bottom: 20px;'> 501-502, Velocity Business Hub NR. Madhuvan Circle, LP Savani Rd, Adajan Gam, Surat, Gujarat - 395009</div>
				<a style='color: rgb(81, 81, 184);' href='https://www.centroall.com'>centroall.com</a></div>
		</div>
	</div>
</div>
</body>
</html>

