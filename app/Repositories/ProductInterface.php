<?php

namespace App\Repositories;

interface ProductInterface
{

    public function paginate ();

    public function create ($validated, $brand, $category);

    public function update ($product, $productData);

    public function delete ($id);

}
