<?php
class Home_Service_Session{
	//过期时间
	private $_LEFT_TIME = 3600;

	public function open() {

	}

	public function close(){
	  
	}

	/**
	 * 读
	 */
	public function read($sessid) {
		$where['sessid'] = $sessid;
		$where['expiry'] = array('>',time());
        $obj = new Home_Dao_Sessions();
		$info = $obj->get($where);
		return $info['data'];
	}

	/**
	 * 写
	 */
	public function write($sessid , $sessdata) {
		$data = array(
				'expiry'    =>   time()+ $this->_LEFT_TIME,
				'data'      =>   $sessdata,
		);
		$owhere['sessid'] = $sessid;
        $obj = new Home_Dao_Sessions();
		$oldData = $obj->get($owhere);
		if($oldData) {
			//更新
			$uwhere['sessid'] = $sessid;
            $obj = new Home_Dao_Sessions();
            $obj->update($data, $uwhere);
			return true;
		} else {
			//插入
			$data['sessid'] = $sessid;
            $obj = new Home_Dao_Sessions();
            $obj->insert($data);
			return true;
		}
	}

	/**
	 * 指定销毁
	 */
	public function destroy($sessid) {
		$dwhere['sessid'] = $sessid;
        $obj = new Home_Dao_Sessions();
        $obj->delete($dwhere);
		return true;
	}

	/**
	 * 销毁过期的数据
	 */
	public function gc() {
		//随机销毁数据,减轻服务器压力
		if( rand(0,3) == 3 ) {
			$where['expiry <'] = time();
            $obj = new Home_Dao_Sessions();
            $obj->delete($where);
			return true;
		}
	}
}