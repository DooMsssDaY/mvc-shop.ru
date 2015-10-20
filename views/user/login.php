<?php include ROOT.'/views/layouts/header.php';?>

<section><!--form-->
		<div class="container">
			<div class="row">
				<div class="col-sm-4 col-sm-offset-4 padding-right">
					<div class="signup-form">
							<h2 class="title text-center">Вход на сайт</h2>

							<?php if (!empty($errors)):?>
								<div class="status alert alert-success">
									<?php foreach($errors as $error):?>
										<span>- <?php echo $error; ?></span><br/>
									<?php endforeach; ?>
								</div>
							<?php endif; ?>

							<form method="post">
								<input type="email" name='email' required="required" placeholder="E-mail"value='<?php echo $email;?>'/>
								<input type="password" required="required" name='password' placeholder="Пароль"/>
								<a href="/user/register" title="">Зарегистрироваться</a>
								<button type="submit" name='submit' class="btn btn-default">Вход</button>
							</form>
					</div>
					<br/>
					<br/>
				</div>
			</div>
		</div>
	</section><!--/form-->

<?php include ROOT.'/views/layouts/footer.php';?>