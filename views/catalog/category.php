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

                    <div class="col-sm-9 padding-right">
                        <div class="features_items"><!--features_items-->
                            <h2 class="title text-center">Последние товары</h2>
                                
                                <?php foreach ($latestProd as $prodItem): ?>
                                    <div class="col-sm-4">
                                        <div class="product-image-wrapper">
                                            <div class="single-products">
                                                <div class="productinfo text-center">
                                                    <img src="<?php echo Product::getImageProduct($prodItem['id']); ?>" alt="" style='max-height:150px;'/>
                                                    <h2><?php echo $prodItem['price'];?>$</h2>
                                                    <p><a href="/product/<?php echo $prodItem['id'];?>"><?php echo $prodItem['name'];?></a></p>
                                                    <a href="javascript:void(0);" product-id='<?php echo $prodItem['id'];?>' class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>В корзину</a>
                                                </div>
                                                <?php if($prodItem['is_new']):?>
                                                    <img src='/template/images/home/new.png' class='new' alt=''/>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>

                        </div><!--features_items-->
                        <?php echo $pagination->get(); ?>
                    </div>
                </div>
            </div>
        </section>

<?php include ROOT.'/views/layouts/footer.php';?>