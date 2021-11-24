<?php

namespace App\Admin\Controllers;

use App\Models\Egg;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class EggController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Egg';

    protected function getPrice(){
        $url = 'https://api.coingecko.com/api/v3/coins/markets?vs_currency=usd&ids=radio-caca';
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HTTPGET, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response_json = curl_exec($ch);
        curl_close($ch);
        return json_decode($response_json, true)[0]["current_price"];
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $price = $this->getPrice();
        $grid = new Grid(new Egg());
        $grid->column('name', __('Name'));
        $grid->column('image_url', __('Image url'))->image("",50,50);
        $grid->id('Mua')->display(function($item){
            return "<span class='label label-success'><a target='_blank' href='https://market.radiocaca.com/#/market-place/".$item."' style='color:white'>Mua</a></span>";
        });
        $grid->column('count', __('Count'))->sortable()->filter('range');
        $grid->column('fixed_price', __('Price (RACA)'))->display(function ($title) {
            return number_format($title, 0);
        })->sortable()->filter('range');
        $grid->column('highest_price', __('Price (USD)'))->display(function () use($price) {
            return number_format($price * $this->fixed_price, 0)." $";
        })->sortable()->filter('range');
        $grid->column('highest_price', __('Highest price'));
        $grid->column('status', __('Status'));

        $grid->disableCreateButton();
        $grid->actions(function ($actions) {
            $actions->disableDelete();
            $actions->disableEdit();
        });
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
        $show = new Show(Egg::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('highest_price', __('Highest price'));
        $show->field('count', __('Count'));
        $show->field('fixed_price', __('Fixed price'));
        $show->field('image_url', __('Image url'));
        $show->field('name', __('Name'));
        $show->field('total_price', __('Total price'));
        $show->field('status', __('Status'));
        $show->field('token_id', __('Token id'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Egg());

        $form->decimal('highest_price', __('Highest price'));
        $form->number('count', __('Count'));
        $form->decimal('fixed_price', __('Fixed price'));
        $form->text('image_url', __('Image url'));
        $form->text('name', __('Name'));
        $form->decimal('total_price', __('Total price'));
        $form->text('status', __('Status'));
        $form->text('token_id', __('Token id'));

        return $form;
    }
}
