<?php

namespace App\Admin\Controllers;

use App\Models\Item;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class ItemController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Item';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function getPrice(){
        $url = 'https://api.coingecko.com/api/v3/coins/markets?vs_currency=usd&ids=radio-caca';
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HTTPGET, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response_json = curl_exec($ch);
        curl_close($ch);
        return json_decode($response_json, true)[0]["current_price"];
    }
    protected function grid()
    {
        $price = $this->getPrice();
        $grid = new Grid(new Item());

        $grid->column('token_id', __('Token id'))->filter('like');
        $grid->column('image_url', __('Image url'))->image("",50,50);
        $grid->column('fixed_price', __('Price (RACA)'))->display(function ($title) {
            return number_format($title, 0);
        })->sortable()->filter('range');
        $grid->column('highest_price', __('Price (USD)'))->display(function () use($price) {
            return number_format($price * $this->fixed_price, 0)." $";
        })->sortable()->filter('range');
        $grid->id('Mua')->display(function($item){
            return "<span class='label label-success'><a target='_blank' href='https://market.radiocaca.com/#/market-place/".$item."' style='color:white'>Mua</a></span>";
        });
        $grid->column('name', __('Name'))->display(function () {
            return "Metamon #".$this->token_id;
        })->filter('like')->sortable();
        $grid->column('rarity', __('Rarity'))->filter([
            'N' => 'N',
            'R' => 'R',
            'SR' => 'SR'
        ]);
        $grid->column('luck', __('Luck'))->sortable()->filter('range');
        $grid->column('stealth', __('Stealth'))->sortable()->filter('range');
        $grid->column('level', __('Level'))->sortable()->filter('range');
        $grid->column('healthy', __('Healthy'))->sortable()->filter('range');
        $grid->column('wishdom', __('Wishdom'))->sortable()->filter('range');
        $grid->column('size', __('Size'))->sortable()->filter('range');
        $grid->column('race', __('Race'))->filter([
            'orc' => 'orc',
            'spirit' => 'spirit',
            'demon' => 'demon',
            'dwarf' => 'dwarf',
            'naga' => 'naga'
        ]);
        $grid->column('courage', __('Courage'))->sortable()->filter('range');
        $grid->column('score', __('Score'))->sortable()->filter('range');
        $grid->column('rate', __('Rate'))->display(function () {
            return round($this->rate, 4);
        })->sortable()->filter('range');
        $grid->column('status', __('Status'));
        $grid->disableCreateButton();
        $grid->actions(function ($actions) {
            $actions->disableDelete();
            $actions->disableEdit();
        });
        $grid->model()->where('score', '!=', null);
        $grid->model()->orderBy('fixed_price');

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(Item::findOrFail($id));

        $show->field('count', __('Count'));
        $show->field('status', __('Status'));
        $show->field('name', __('Name'));
        $show->field('sale_address', __('Sale address'));
        $show->field('image_url', __('Image url'));
        $show->field('token_id', __('Token id'));
        $show->field('highest_price', __('Highest price'));
        $show->field('id', __('Id'));
        $show->field('sale_type', __('Sale type'));
        $show->field('rarity', __('Rarity'));
        $show->field('luck', __('Luck'));
        $show->field('stealth', __('Stealth'));
        $show->field('level', __('Level'));
        $show->field('healthy', __('Healthy'));
        $show->field('wishdom', __('Wishdom'));
        $show->field('size', __('Size'));
        $show->field('race', __('Race'));
        $show->field('courage', __('Courage'));
        $show->field('score', __('Score'));
        $show->field('fixed_price', __('Fixed price'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Item());

        $form->number('count', __('Count'));
        $form->text('status', __('Status'));
        $form->text('name', __('Name'));
        $form->text('sale_address', __('Sale address'));
        $form->text('image_url', __('Image url'));
        $form->text('token_id', __('Token id'));
        $form->text('highest_price', __('Highest price'));
        $form->text('sale_type', __('Sale type'));
        $form->text('rarity', __('Rarity'));
        $form->number('luck', __('Luck'));
        $form->number('stealth', __('Stealth'));
        $form->number('level', __('Level'));
        $form->number('healthy', __('Healthy'));
        $form->number('wishdom', __('Wishdom'));
        $form->number('size', __('Size'));
        $form->text('race', __('Race'));
        $form->number('courage', __('Courage'));
        $form->number('score', __('Score'));
        $form->number('fixed_price', __('Fixed price'));

        return $form;
    }
}
