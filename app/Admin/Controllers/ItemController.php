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
    protected function grid()
    {
        $grid = new Grid(new Item());

        $grid->column('status', __('Status'));
        $grid->column('start_time', __('Start time'));
        $grid->column('image_url', __('Image url'))->image("",50,50);
        $grid->column('token_id', __('Token id'));
        $grid->column('fixed_price', __('Fixed price'))->display(function ($title) {
            return number_format($title);
        })->sortable();
        $grid->id('Mua')->display(function($item){
            return "<span class='label label-success'><a href='https://market.radiocaca.com/#/market-place/".$item."' style='color:white'>".$item."</a></span>";
        })->sortable();
        $grid->column('name', __('Name'));
        $grid->column('rarity', __('Rarity'))->sortable();
        $grid->column('luck', __('Luck'))->sortable();
        $grid->column('stealth', __('Stealth'))->sortable();
        $grid->column('level', __('Level'))->sortable();
        $grid->column('healthy', __('Healthy'))->sortable();
        $grid->column('wishdom', __('Wishdom'))->sortable();
        $grid->column('size', __('Size'))->sortable();
        $grid->column('race', __('Race'))->sortable();
        $grid->column('courage', __('Courage'))->sortable();
        $grid->column('score', __('Score'))->sortable();
        $grid->column('highest_price', __('highest price'))->display(function ($title) {
            return number_format($title);
        });

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
        $show->field('start_time', __('Start time'));
        $show->field('image_url', __('Image url'));
        $show->field('end_time', __('End time'));
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
        $form->number('start_time', __('Start time'));
        $form->text('image_url', __('Image url'));
        $form->number('end_time', __('End time'));
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
