<?php


namespace app\admin\controller;

use thans\layuiAdmin\facade\AdminsAuth;
use thans\layuiAdmin\facade\Json;
use thans\layuiAdmin\facade\Utils;
use thans\layuiAdmin\Form;
use thans\layuiAdmin\Table;
use thans\layuiAdmin\Traits\FormActions;
use thans\user\model\User;
use think\Request;

class UserController
{
    use FormActions;

    public function __construct()
    {
        $this->route = false;
    }

    public function index(Request $request)
    {
        if ($request->isAjax()) {
            list($where, $order, $page, $limit) = Utils::buildParams('name|mobile|email|nickname');
            $user  = User::where($where)->order($order);
            $list  = $user->page($page)->limit($limit)->select();
            $total = $user->count();
            Json::success('获取成功', $list, ['total' => $total]);
        }
        $tb = new Table();
        $tb->title('用户管理');
        $tb->url(url('app\admin\controller\UserController/index'));
        $tb->column('id', 'ID', 150);
        $tb->column('nickname', '昵称');
        $tb->column('mobile', '手机号');
        $tb->column('email', '邮箱');
        $tb->column('name', '用户名');
        $tb->status()->option('0', '正常')->option('1', '封禁');
        $tb->column('status', '状态', '80', 'status');
        $tb->column('last_login_time', '最后登录时间');
        $tb->column('last_login_ip', '最后登录IP');
        $tb->column('register_ip', '注册IP');
        $url = url('app\admin\controller\UserController/edit', ['id' => '{{ d.id }}']);
        if (AdminsAuth::check($url)) {
            $tb->tool('编辑', $url, 'formLayer');
        }

        return $tb->render();
    }

    public function buildForm()
    {
        $form = new Form(new User(), new \app\admin\validate\User());
        $form->text()->label('用户名')->name('name')->rules('', false, 5, 50, '请输入5-50位的用户名');
        $form->text()->label('昵称')->name('nickname')->rules('', false, 5, 50, '请输入5-50位的用昵称');
        $form->text()->label('手机号')->name('mobile')->rules('mobile', false);
        $form->text()->label('邮箱')->name('email')->rule('email', false);
        $form->text()->label('密码')->name('password')->placeholder('不更新留空');
        $op[] = ['val' => 0, 'title' => '正常'];
        $op[] = ['val' => 1, 'title' => '封禁'];
        $form->select()->option($op)->label('状态')->name('status');

        return $form;
    }

    public function delete($id)
    {
    }

    public function create(Request $request)
    {
    }

    public function save(Request $request)
    {
    }
}
