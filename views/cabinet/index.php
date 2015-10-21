<?php include ROOT.'/views/layouts/header.php';?>

		<div class="container">
			<div class="row">
				<h2>Кабинет пользователя <?php echo $user['name'];?></h2>

				<ul>
					<?php if(User::isAdmin()):?>
					<li><a href="/admin/" title="">Админпанель</a></li>
					<?php endif;?>
					<li><a href="/cabinet/edit" title="">Редактировать данные</a></li>
					<li><a href="/cabinet/history" title="">История заказов</a></li>
				</ul>
			</div>
		</div>

<?php include ROOT.'/views/layouts/footer.php';?>