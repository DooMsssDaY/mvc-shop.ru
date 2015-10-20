<?php include ROOT.'/views/layouts/header.php';?>

<section><!--form-->
		<div class="container">
			<div class="row">

				<div class="col-sm-4 col-sm-offset-4 padding-right">
					<div class="signup-form"><!--sign up form-->
						
						<?php if ($changeUserDataSuccess):?>
							<h2>Данные изменены</h2>
							<a href='/cabinet/'>в личный кабинет</a>
						<?php else: ?>
							<h2 class="title text-center">Изменение пользовательских данных</h2>

							<?php if (!empty($errors)):?>
								<div class="status alert alert-success">
									<?php foreach($errors as $error):?>
										<span>- <?php echo $error; ?></span><br/>
									<?php endforeach; ?>
								</div>
							<?php endif; ?>

							<form method="post">
								<input type="text" name='name' required="required" placeholder="Имя" value='<?php echo $user['name'];?>'/>
								<input type="email" name='email' required="required" placeholder="E-mail" value='<?php echo $user['email'];?>'/>
								<input type="password" name='password' required="required" placeholder="Пароль" value='<?php echo $user['password'];?>'/>
								<input type="password" name='password2' required="required" placeholder="Повтор пароля"/>
								<button type="submit" name='submit' class="btn btn-default">Сохранить</button>
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