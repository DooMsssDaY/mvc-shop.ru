<?php include ROOT.'/views/layouts/header.php';?>

<section><!--form-->
		<div class="container">
			<div class="row">

				<div class="col-sm-4 col-sm-offset-4 padding-right">
					<div class="signup-form"><!--sign up form-->
						
						<?php if ($regSuccess):?>
							<h2>Регистрация прошла успешно!</h2>
							<a href='/'>перейти на главную страницу</a>
						<?php else: ?>
							<h2 class="title text-center">Регистрация на сайте</h2>

							<?php if (!empty($errors)):?>
								<div class="status alert alert-success">
									<?php foreach($errors as $error):?>
										<span>- <?php echo $error; ?></span><br/>
									<?php endforeach; ?>
								</div>
							<?php endif; ?>

							<form action="#" method="post">
								<input type="text" name='name' required="required" placeholder="Имя" value='<?php echo $name;?>'/>
								<input type="email" name='email' required="required" placeholder="E-mail" value='<?php echo $email;?>'/>
								<input type="phone" name='phone' required="required" placeholder="телефон" value='<?php echo $phone;?>'/>
								<input type="password" name='password' required="required" placeholder="Пароль" value='<?php echo $password;?>'/>
								<input type="text" name='address' required="required" placeholder="Ваш адрес" value='<?php echo $address;?>'/>
								<button type="submit" name='submit' class="btn btn-default">Регистрация</button>
							</form>
						<?php endif; ?>
					</div><!--/sign up form-->
					<br/>
					<br/>
				</div>
			</div>
		</div>
	</section><!--/form-->

<?php include ROOT.'/views/layouts/footer.php';?>