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

				<div class="col-sm-8 col-sm-offset-1 padding-right">
					<div class='features_items'>
							<h2 class="title text-center">Корзина</h2>

								<?php if (!$productsInCart):?>
									<p>Ваша корзина пуста.</p>
								<?php else: ?>
									<p>Вы выбрали следующие товары</p>
									<table class='table-bordered table-striped table'>
										<thead>
											<tr>
												<th>Код товара</th>
												<th>Название</th>
												<th>Стоимость $</th>
												<th>Кол-во, шт</th>
												<th></th>
											</tr>
										</thead>
										<tbody>
											<?php foreach ($products as $item): ?>
												<tr>
													<td><?php echo $item['code']; ?></td>
													<td><?php echo $item['name']; ?></td>
													<td><?php echo $item['price']; ?></td>
													<td><?php echo $productsInCart[$item['id']]; ?></td>
													<td><a href='/cart/deleteItem/<?php echo $item['id'];?>'>Удалить</a></td>
												</tr>
											<?php endforeach; ?>
											<tr>
												<td colspan='3'>общая стоимость: </td>
												<td colspan='4'><?php echo $totalPrice; ?></td>
											</tr>
										</tbody>
									</table>
									<a href="/order/" class="col-sm-3 col-sm-offset-9 padding-right"><i class="fa fa-shopping-cart"></i> Оформить заказ</a>
							<?php endif; ?>
							<br/>
							<br/>
					</div>
				</div>

			</div>
		</div>

<?php include ROOT.'/views/layouts/footer.php';?>