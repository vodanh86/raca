<?php

namespace App\Admin\Controllers;

use App\Models\Mowa;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class MowaController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Mowa';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Mowa());

        $grid->column('id', __('Id'));
        $grid->column('token_id', __('Token id'));
        $grid->column('nft_id', __('Nft id'));
        $grid->column('name', __('Name'));
        $grid->column('icon', __('Icon'));
        $grid->column('price', __('Price'));
        $grid->column('type', __('Type'));
        $grid->column('level', __('Level'));
        $grid->column('start', __('Start'));
        $grid->column('skill_level', __('Skill level'));
        $grid->column('mowa_id', __('Mowa id'));

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
        $show = new Show(Mowa::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('token_id', __('Token id'));
        $show->field('nft_id', __('Nft id'));
        $show->field('name', __('Name'));
        $show->field('icon', __('Icon'));
        $show->field('price', __('Price'));
        $show->field('type', __('Type'));
        $show->field('level', __('Level'));
        $show->field('start', __('Start'));
        $show->field('skill_level', __('Skill level'));
        $show->field('mowa_id', __('Mowa id'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Mowa());

        $form->number('token_id', __('Token id'));
        $form->number('nft_id', __('Nft id'));
        $form->text('name', __('Name'));
        $form->text('icon', __('Icon'));
        $form->number('price', __('Price'));
        $form->text('type', __('Type'));
        $form->number('level', __('Level'));
        $form->number('start', __('Start'));
        $form->number('skill_level', __('Skill level'));
        $form->text('mowa_id', __('Mowa id'));

        return $form;
    }
}
