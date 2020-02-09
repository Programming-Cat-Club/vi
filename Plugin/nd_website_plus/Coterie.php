<?php
/*   __________________________________________________
    |              http://www.daniuwo.com              |
    |                    QQ:956716282                  |
    |__________________________________________________|
*/
namespace Action;
class Coterie extends HYBBS
{
	public function Index(){
		//{hook a_coterie_index_1}
		$this->v('title',$this->conf['title']);

		$pageid	= intval(X('get.pageid')) 	or $pageid=1;
		$type 	= X('get.type') 			or $type='New';
		
		if($type != 'New' && $type != 'Btime')
			$type='';
        $this->v('title',"圈子");
        $this->v("type",strtolower($type));
		$Thread = M("Thread");
		$desc = ['btime' => 'DESC'];
		if($type == 'Btime')
			$desc = ['btime'=>'DESC']; //最新回复

		//{hook a_coterie_index_11}
		$thread_list = $this->CacheObj->get("index_index_".$type.'_'.$pageid);
		//获取主题列表
		if(empty($thread_list) || DEBUG){
			//{hook a_coterie_index_22}
			$thread_list = $Thread->get_thread_list($pageid,$this->conf['homelist'],$desc);
			$Thread->format($thread_list);
			foreach ($thread_list as $key => $value) {
				if($value['top'] == 2)
					unset($thread_list[$key]);
			}
			$this->CacheObj->set("index_index_".$type.'_'.$pageid,$thread_list);
        }
		//{hook a_coterie_index_2}

		//获取置顶缓存
		$top_data=$this->CacheObj->get("top_data_2");
		if(empty($top_data) || DEBUG){
			//{hook a_coterie_index_33}
			//全局置顶
	        $top_data = $Thread->get_top_thread();
	        //格式数据显示
	        $Thread->format($top_data);
	        //写入缓存
			$this->CacheObj->set("top_data_2",$top_data);
		}
		//End
		//{hook a_coterie_index_3}


		$count = $this->_count['thread'];
		$count = (!$count)?1:$count;
		$page_count = ($count % $this->conf['homelist'] != 0)?(intval($count/$this->conf['homelist'])+1) : intval($count/$this->conf['homelist']);
		
		//{hook a_coterie_index_v}

		$this->v("pageid",$pageid);
		$this->v("page_count",$page_count);
		$this->v("data",$thread_list);

        $this->display('coterie_index');
    }
    // 关注
    public function follow()
    {
        // 查询关注
        $this->v("data",$data = []);
        if(IS_LOGIN){
            $friend = S('friend')->select('*',['uid1'=>NOW_UID]);
            if(!empty($friend)){
                //实例UserModel对象
                $this->v("friend",true);
                $User = M("User");
                $follow=[];
                //通过id获得用户名
                foreach($friend as $k=>$v){
                    $follow[$k] = $v['uid2'];
                }
                $Thread = M('Thread');
                $data = $Thread->select('*',['uid'=>$follow,'ORDER'=>['atime'=> 'DESC']]);
                if(!empty($follow)){
                    if(!is_array($follow)){
                        $follow =[$follow];
                    }
                    if($follow['0'] == 0){
                        unset($follow['0']);
                    }
                    foreach($follow as &$v){
                        $v = ['uid'=>$v];
                        $v['user'] = $User->uid_to_user($v);
                        $v['avatar'] = get_avatar($v['uid']);
                    }   
                }
                if(!empty($data)){
                    foreach($data as &$v){

                        $v['user'] = $User->uid_to_user($v['uid']);
                        $v['avatar'] = get_avatar($v['uid']);
                    }
                }
                $this->v("follow",$follow);
                $this->v("data",$data);
            }else{
                $this->v("friend",false);
            }
        }
        $this->v("title",'关注');
        $this->display('coterie_follow');
    }
    // 找人列表
    public function lookfor()
    {
        $this->v('title','找人');
        $pageid=intval(isset($_GET['HY_URL'][2]) ? $_GET['HY_URL'][2] : 1) or $pageid=1;
        // var_dump($_GET['HY_URL'][2]);
        $User = M('User');
        $User_data = $User->select('*',[
            'ORDER'=>['uid'=>'ASC'],//DESC
            'LIMIT' =>[($pageid-1) * 10, 10],
        ]);
        // var_dump($User_data);
        $Online = S("Online");
        foreach($User_data as &$v){
            $v['ztime']     = $Online->has(['uid'=>$v['uid']])?$Online->find('atime',['uid'=>$v['uid']]):$v['atime'];
            $v['user']      = $User->uid_to_user($v['uid']);
            $v['avatar']    = get_avatar($v['uid']);
        }
        $count = $User->count();
        $page_count = ($count % 10 != 0)?(intval($count/10)+1) : intval($count/10);

        $this->v("count",$count);
        $this->v("pageid",$pageid);
        $this->v("page_count",$page_count);
        $this->v('user_data',$User_data);
        $this->display('coterie_lookfor');
    }
    // 找人 搜人
    public function Search(){
        $pageid=intval(isset($_GET['HY_URL'][2]) ? $_GET['HY_URL'][2] : 1) or $pageid=1;
        $user = htmlentities(X('get.user'));
        $User = M('User');
        $data = $User->select("*", array(
            "user[~]" => $user,
            'LIMIT' =>[($pageid-1) * 10, 10],
        ));
        $data_count = $User->count("*", array(
            "user[~]" => $user
        ));
        $Online = S("Online");
        foreach($data as &$v){
            $v['ztime']     = $Online->has(['uid'=>$v['uid']])?$Online->find('atime',['uid'=>$v['uid']]):$v['atime'];
            $v['user']      = $User->uid_to_user($v['uid']);
            $v['avatar']    = get_avatar($v['uid']);
        }
        $count = $User->count();
        $page_count = ($count % 10 != 0)?(intval($count/10)+1) : intval($count/10);
        $this->v('title','找人');
        $this->v("count",$count);
        $this->v("pageid",$pageid);
        $this->v("page_count",$page_count);
        $this->v('data',$data);
        $this->display('coterie_search');
    }
}
