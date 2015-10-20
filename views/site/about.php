<?php include ROOT.'/views/layouts/header.php';?>
        <section>
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
                                                <a href="/category/<?php echo $categoryItem['id']; ?>">
                                                    <?php echo $categoryItem['name']; ?>
                                                </a>
                                            </h4>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>

                        </div>
                    </div>

                    <div class="col-sm-9 padding-right">
                        <div class="features_items"><!--features_items-->
                            <h2 class="title text-center">О проекте</h2>
                            <p>Данный интернет-магазин работает на рукописньм MVC движке, который был реализован мною, с целью демонстрации знаний PHP, ООП и паттерна MVC.</p>
                            <p>Были реализованные все ключевые элементы современного интернет-магазина:</p>
                            <ul>
                                <li>- регистрация и авторизация пользователей</li>
                                <li>- Карзина</li>
                                <li>- Создние заказов</li>
                                <li>- Личный кабинет</li>
                                <li>- Админпанель</li>
                                <li>- Управление заказами, категориями, товарами(CRUD)</li>
                                <li>- Отправка писем</li>
                                <li>- и т.д.</li>
                            </ul>
                            <p>При разработке мазагина был использован html/css шаблон 'E-shopper', скаченный с сайта <a target='_blank' href='http://kimoncar.ru/shablon-internet-magazina-e-shopper'>kimoncar.ru</a></p>
                        </div><!--features_items-->

                    </div>
                </div>
            </div>
        </section>

<?php include ROOT.'/views/layouts/footer.php';?>