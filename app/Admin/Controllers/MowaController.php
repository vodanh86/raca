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

        $grid->column('token_id', __('Token id'));
        $grid->mowa_id('Mua')->display(function($item){
            return "<span class='label label-success'><a target='_blank' href='https://dapp.moniwar.io/nft/market-detail?id=".$item."' style='color:white'>Mua</a></span>";
        });
        $grid->column('name', __('Name'))->sortable()->filter('like');
        $grid->column('icon', __('Icon'))->image("",60,60);
        $grid->column('price', __('Price'))->display(function ($title) {
            return number_format($title, 0);
        })->sortable()->filter('range');
        $grid->column('type', __('Type'))->sortable()->filter('like');
        $grid->column('level', __('Level'))->sortable()->filter('range');
        $grid->column('start', __('Start'))->sortable()->filter('range');
        $grid->column('skill_level', __('Skill level'))->sortable()->filter('range');
        $grid->disableCreateButton();
        $grid->actions(function ($actions) {
            $actions->disableDelete();
            $actions->disableEdit();
        });
        $grid->model()->orderBy('price');
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
