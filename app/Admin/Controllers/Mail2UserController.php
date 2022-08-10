<?php

namespace App\Admin\Controllers;

use App\Mail2User;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class Mail2UserController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Mail2User';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Mail2User());

        $grid->column('id', __('Id'));
        $grid->column('s_region', __('S region'));
        $grid->column('name', __('Name'));
        $grid->column('created_at', __('Created at'));
        $grid->column('updated_at', __('Updated at'));

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
        $show = new Show(Mail2User::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('s_region', __('S region'));
        $show->field('name', __('Name'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Mail2User());
        $_users = DB::table('rawsurvey')->select('s_region')->distinct()->get();

        $_s_regions = array();
        foreach($_users as $item)
        {
            $_s_regions[$item->s_region] = $item->s_region;
        }
        $form->select('s_region', 'S region')->options($_s_regions);
        $form->text('name', __('Name'));

        return $form;
    }
}
