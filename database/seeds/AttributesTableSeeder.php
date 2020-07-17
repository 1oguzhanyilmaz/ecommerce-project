<?php

use Illuminate\Database\Seeder;

class AttributesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $attributeSize = App\Attribute::create([
            'code' => 'S-00',
            'name' => 'Size',
            'type' => 'select',
        ]);
        $sizeOptions = ['S','M','L','XL'];
        $this->setOptions($attributeSize->id, $sizeOptions);

        $attributeColor = App\Attribute::create([
            'code' => 'C-00',
            'name' => 'Color',
            'type' => 'select',
        ]);
        $colorOptions = ['Black','White','Red'];
        $this->setOptions($attributeColor->id, $colorOptions);
    }

    private function setOptions($attributeId, $options){
        foreach ($options as $option){
            \App\AttributeOption::create([
                'attribute_id' => $attributeId,
                'name' => $option,
            ]);
        }
    }
}
