<?php

foreach (glob('classes/' . "*.php") as $file) {
    if (strpos($file, 'index') === false) {
        include_once $file;
    }
}

User::check_page(2);

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Inventory • Restaurant</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="css/inventory.css">
    <?php include './head.php'; ?>
</head>
<body>
<?php include './header.php'; ?>
    <div class="page">
        <div class="sideMenu">
            <div class="categoryContainers">
                <div class="categoryContainer">
                    <h4 class="categoryTitle">Add Product</h4>
                    <div class="divider"></div>
                    <div class="category addProduct">
                        <div class="inputContainer">
                            <div class="add-product-header">
                                <label for="product-name">Product Name</label>
                                <span class="add-product-clear" title="Clear add product details">×</span>
                            </div>
                            <input type="text" name="product-name" id="product-name">
                            <span class="display-error"></span>
                        </div>
                        <div class="inputContainer inputContainerMultiple">
                            <div class="inputContainerChild">
                                <label for="stock">Stock</label>
                                <input type="number" min="0" name="stock" id="stock">
                                <span class="display-error"></span>
                            </div>
                            <div class="inputContainerChild">
                                <label for="price">Price</label>
                                <input type="number" min="0" id="price" name="price">
                                <span class="display-error"></span>
                            </div>
                        </div>
                        <div class="menu-item">
                            <label for="measure_unit">Measure unit</label>
                            <select name="measure_unit" id="measure_unit">
                                <option value="" disabled selected>Select measure unit</option>
                                <option value="l">L</option>
                                <option value="buc">Pieces</option>
                                <option value="kg">Kg</option>
                            </select>
                            <span class="display-error"></span>
                        </div>
                        <button class="addProductBtn button_custom">Add</button>
                    </div>
                </div>
                <div class="categoryContainer">
                    <h4 class="categoryTitle">Edit Product</h4>
                    <div class="divider"></div>
                    <div class="category editProduct">
                        <div class="inputContainer">
                            <div class="edit-product-header">
                                <label for="edit-product-name">Product Name</label>
                                <span class="edit-product-clear" title="Clear edit product details">×</span>
                            </div>
                            <input type="text" name="product-name" id="edit-product-name" disabled="disabled">
                        </div>
                        <div class="inputContainer inputContainerMultiple">
                            <div class="inputContainerChild">
                                <label for="edit-stock">Stock</label>
                                <input type="number" min="0" name="edit-stock" id="edit-stock" disabled="disabled">
                                <span class="display-error"></span>
                            </div>
                            <div class="inputContainerChild">
                                <label for="edit-price">Price</label>
                                <input type="number" min="0" id="edit-price" name="edit-price" disabled="disabled">
                                <span class="display-error"></span>
                            </div>
                        </div>
                        <input type="hidden" id="edit-id">
                        <button class="editProductBtn button_custom">Save</button>
                    </div>
                </div>
            </div>
            <div class="btnContainer">
                <div class="btnSection">
                    <button class="majorBtn inventory_import_csv">Import</button>
                    <a class="majorBtn" target="_blank" rel="noreferrer noopener nofollow" href="<?php echo Link::getLink('exportCsv', 'events', ['action' => 'exportInventory']); ?>">Export</a>
                </div>
                <button class="majorBtn btnFullWidth deleteProductBtn">Delete</button>
            </div>
        </div>
        <div class="container_custom">
            <div class="go-loader-wrapper">
                <div class="lds-roller"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>
            </div>
            <table class="inventory-table">
                <tr class="table-headers">
                    <th class="table-title">ID</th>
                    <th class="table-title">Picture</th>
                    <th class="table-title">Name</th>
                    <th class="table-title">Stock (g)</th>
                    <th class="table-title">Measure</th>
                    <th class="table-title">Price (RON)</th>
                </tr>
                <?php
                    $products = Inventory::loadInventory();
                    foreach ($products as $product) {
                        echo '
                <tr class="table-rows" data-id="'.$product['ID'].'">
                    <td class="table-cell product_id">'.$product['ID'].'</td>
                    <td class="table-cell">
                        <div class="product_image">
                            <img src="assets/food.png" class="product_img" alt="">
                        </div>
                    </td>
                    <td class="table-cell product_name">'.$product['product'].'</td>
                    <td class="table-cell product_stock">'.$product['stock'].'</td>
                    <td class="table-cell product_measure">'.$product['measure'].'</td>
                    <td class="table-cell product_price">'.$product['price'].'</td>
                </tr>';
                    }
                ?>
            </table>
        </div>
    </div>
    <div class="modal" tabindex="-1" role="dialog" id="inventory_import_csv">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Import CSV</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form enctype="multipart/form-data" method="post" action="<?php echo Link::getLink('importCsv', 'events'); ?>" id="import_csv_form">
                        <div class="form-group">
                            <input type="file" name="file" id="file">
                            <input type="submit" name="import_csv_submit" value="Submit" class="majorBtn btnFullWidth">
                            <a class="majorBtn btnFullWidth" target="_blank" rel="noreferrer noopener nofollow" href="<?php echo Link::getLink('exportCsv', 'events', ['action' => 'exportTemplate']); ?>">Export Template</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
<?php include './foo.php'; ?>
<script src="./js/inventory.js"></script>
</html>
