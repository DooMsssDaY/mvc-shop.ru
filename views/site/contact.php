<?php include ROOT.'/views/layouts/header.php';?>

<section><!--form-->
		<div class="container">
			<div class="row">
				<div class="col-sm-8 col-sm-offset-2 padding-right">
					<div class="contact-form">	

						<?php if ($successSend):?>
							<h2>Ваше сообщение отправленно.</h2>
							<a href='/'>Перейти на главную страницу</a>
						<?php else: ?>
							<h2 class="title text-center">Обратная связь</h2>

							<?php if (!empty($errors)):?>
								<div class="status alert alert-success">
										<?php foreach($errors as $error):?>
											<span>- <?php echo $error; ?></span><br/>
										<?php endforeach; ?>
								</div>
							<?php endif; ?>

					    	<form id="main-contact-form" class="contact-form row" name="contact-form" method="post">
					            <div class="form-group col-md-6">
					                <input type="text" name="name" class="form-control" required="required" placeholder="Имя">
					            </div>
					            <div class="form-group col-md-6">
					                <input type="email" name="email" class="form-control" required="required" placeholder="Email">
					            </div>
					            <div class="form-group col-md-12">
					                <input type="text" name="subject" class="form-control" required="required" placeholder="Тема письма">
					            </div>
					            <div class="form-group col-md-12">
					                <textarea name="message" id="message" required="required" class="form-control" rows="8" placeholder="Сообщение"></textarea>
					            </div>                        
					            <div class="form-group col-md-12">
					                <input type="submit" name="submit" class="btn btn-primary pull-right" value="Отправить">
					            </div>
					        </form>

						<?php endif; ?>
	    			</div>
					</div>
					<br/>
					<br/>

			</div>
		</div>
	</section><!--/form-->

<?php include ROOT.'/views/layouts/footer.php';?>