<?php include ROOT.'/views/layouts/header.php';?>

		<div class="container">
			<div class="row">
                <div class="col-sm-3">
                    <div class="left-sidebar">
                        <h2>Каталог</h2>
                        <div class="panel-group category-products">
                            
                            <?php foreach ($categories as $categoryItem): ?>
                                
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                            <a class="<?php echo ($categoryItem['id'] == $catId) ? 'active' : ''?>" 
                                               href="/category/<?php echo $categoryItem['id']; ?>">
                                                <?php echo $categoryItem['name']; ?>
                                            </a>
                                        </h4>
                                    </div>
                                </div>
                            <?php endforeach;?>
                        </div>
                    </div>
                </div>

				<div class="col-sm-4 col-sm-offset-3 padding-right">
							<h2 class="title text-center">Оформление заказа</h2>

								<?php if ($successOrder):?>
									<p>Заказ оформлен. В ближайшее время с Вами свяжется наш менеджер.</p>
								<?php else: ?>
                                    <div class="signup-form">
									<p>Вы выбрали <?php echo $totalItems;?> товаров на сумму <?php echo $totalPrice;?>$</p>
                                    <?php if (!empty($errors)):?>
                                        <div class="status alert alert-success">
                                            <?php foreach($errors as $error):?>
                                                <span>- <?php echo $error; ?></span><br/>
                                            <?php endforeach; ?>
                                        </div>
                                    <?php endif; ?>

                                    <form method="post">
                                        <input type="text" name='name' required="required" placeholder="Имя" value='<?php echo $name;?>'/>
                                        <input type="email" name='email' required="required" placeholder="E-mail" value='<?php echo $email;?>'/>
                                        <input type="phone" name='phone' required="required" placeholder="телефон" value='<?php echo $phone;?>'/>
                                        <input type="text" name='address' required="required" placeholder="Ваш адрес" value='<?php echo $address;?>'/>
                                        <textarea name="message" rows="4" placeholder="Дополнительная информация" value='<?php echo $message;?>'></textarea>
                                        <button type="submit" name='submit' class="btn btn-default">Отправить заказ</button>
                                    </form>
                                    </div>
							    <?php endif; ?>

							<br/>
							<br/>
				</div>

			</div>
		</div>

<?php include ROOT.'/views/layouts/footer.php';?>