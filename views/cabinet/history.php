<?php include ROOT.'/views/layouts/header.php';?>

<section>
    <div class="container">
        <div class="row">


            <h2 class="title text-center">Список заказов</h2>
            
            <table class="table-bordered table">
                <tr>
                    <th>ID заказа</th>
                    <th>Дата оформления</th>
                    <th>Статус</th>
                </tr>
                <?php foreach ($orders as $order): ?>
                    <tr style='background-color: <?php echo Order::getStatusColor($order['status']); ?>;'>
                        <td>
                            <a href="/cabinet/history/view/<?php echo $order['id']; ?>">
                                <?php echo $order['id']; ?>
                            </a>
                        </td>
                        <td><?php echo $order['date']; ?></td>
                        <td><?php echo Order::getStatusText($order['status']); ?></td>    
                        <td><a href="/cabinet/history/view/<?php echo $order['id']; ?>" title="Смотреть"><i class="fa fa-eye"></i></a></td>
                    </tr>
                <?php endforeach; ?>
            </table>

        </div>
    </div>
</section>

<?php include ROOT.'/views/layouts/footer.php';?>