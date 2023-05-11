<?php

namespace Beike\Admin\Services;

use Beike\Models\Product;
use Illuminate\Support\Facades\DB;

class ProductService
{
    public function create(array $data): Product
    {
        $product = new Product;

        return $this->createOrUpdate($product, $data);
    }

    public function update(Product $product, array $data): Product
    {
        return $this->createOrUpdate($product, $data);
    }

    protected function createOrUpdate(Product $product, array $data): Product
    {
        $isUpdating = $product->id > 0;

        try {
            DB::beginTransaction();

            $data['brand_id']  = (int) $data['brand_id'];
            $data['position']  = (int) $data['position'];
            $data['weight']    = (float) $data['weight'];
            $data['variables'] = json_decode($data['variables']);
            $product->fill($data);
            $product->updated_at = now();
            $product->save();

            if ($isUpdating) {
                $product->skus()->delete();
                $product->descriptions()->delete();
                $product->attributes()->delete();
            }

            $descriptions = [];
            foreach ($data['descriptions'] as $locale => $description) {
                $description['locale']  = $locale;
                $description['content'] = $description['content'] ?? '';

                $descriptions[] = $description;
            }
            $product->descriptions()->createMany($descriptions);

            $product->attributes()->createMany($data['attributes'] ?? []);

            $skus = [];
            foreach ($data['skus'] as $index => $sku) {
                $sku['position']     = $index;
                $sku['origin_price'] = (float) $sku['origin_price'];
                $sku['cost_price']   = (float) $sku['cost_price'];
                $sku['quantity']     = (int) $sku['quantity'];
                $skus[]              = $sku;
            }
            $product->skus()->createMany($skus);

            $product->categories()->sync($data['categories'] ?? []);
            $product->relations()->sync($data['relations'] ?? []);

            DB::commit();

            return $product;
        } catch (\Exception $e) {
            DB::rollBack();

            throw $e;
        }
    }
}
