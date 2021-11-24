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

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Egg());

        $grid->column('id', __('Id'));
        $grid->column('highest_price', __('Highest price'));
        $grid->column('count', __('Count'));
        $grid->column('fixed_price', __('Fixed price'));
        $grid->column('image_url', __('Image url'));
        $grid->column('name', __('Name'));
        $grid->column('total_price', __('Total price'));
        $grid->column('status', __('Status'));
        $grid->column('token_id', __('Token id'));

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
