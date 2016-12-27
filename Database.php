<?php
/**
 * Created by PhpStorm.
 * User: 최진욱
 * Date: 2016-12-14
 * Time: 오후 4:51
 */
    require_once "config/config.php";
    require_once "config/function.php";

    class Database
    {
        private $host      = DB_HOST;
        private $user      = DB_USER;
        private $pass      = DB_PASS;
        private $dbname    = DB_NAME;

        private $dbh;
        private $error;

        private $stmt;

        public function __construct()
        {
            // Set DSN
            $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbname;

            // Set options
            $options = [
                PDO::ATTR_PERSISTENT    => true,
                PDO::ATTR_ERRMODE       => PDO::ERRMODE_EXCEPTION
            ];

            // Create a new PDO instanace
            try {
                $this->dbh = new PDO($dsn, $this->user, $this->pass, $options);
                $this->dbh->exec("SET CHARACTER SET utf8");
            }
                // Catch any errors
            catch (PDOException $e) {
                $this->error = $e->getMessage();
            }
        }

        public function query($query)
        {
            $this->stmt = $this->dbh->prepare($query);
        }

        public function bind($param, $value, $type = null)
        {
            if (is_null($type)) {
                switch (true) {
                    case is_int($value):
                        $type = PDO::PARAM_INT;
                        break;
                    case is_bool($value):
                        $type = PDO::PARAM_BOOL;
                        break;
                    case is_null($value):
                        $type = PDO::PARAM_NULL;
                        break;
                    default:
                        $type = PDO::PARAM_STR;
                }
            }

            $this->stmt->bindValue($param, $value, $type);
        }

        public function execute()
        {
            return $this->stmt->execute();
        }

        public function resultset()
        {
            $this->execute();
            return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function single()
        {
            $this->execute();
            return $this->stmt->fetch(PDO::FETCH_ASSOC);
        }

        public function rowCount()
        {
            return $this->stmt->rowCount();
        }

        public function lastInsertId()
        {
            return $this->dbh->lastInsertId();
        }

        public function debugDumpParams()
        {
            return $this->stmt->debugDumpParams();
        }

        public function beginTransaction()
        {
            return $this->dbh->beginTransaction();
        }

        public function endTransaction()
        {
            return $this->dbh->commit();
        }

        public function cancelTransaction()
        {
            return $this->dbh->rollBack();
        }

        public function getConnection()
        {
            return $this->dbh;
        }

        public function getDisConnection()
        {
            $this->dbh = null;
        }

        /**
         * 코드 데이터 반환
         *
         * @param $code
         * @return mixed
         */
        public function getCodes($code)
        {
            $sql = "select id, name from tbl_code where code = :code";
            $this->query($sql);
            $this->bind(":code", $code);

            return $this->resultset($sql);
        }

        // 코드 데이터 상세 반환
        public function getCode($code, $id)
        {
            $sql = "select code, id, name from tbl_code where code = :code and id = :id";
            $this->query($sql);
            $this->bind(":code", $code);
            $this->bind(":id", $id);
            return $this->single();
        }

        /**
         * 항목별 가중치 계산
         * 
         * @param $infos
         * @return array
         */
        public function calculateWeightItems($infos)
        {
            $result = [];

            foreach($infos as $k=>$v) {
                if ($k === 'age' || $k === 'salary') {
                    $data = $this->getCalculateRangeWeightItem($k, $v);
                } else {
                    $v = $this->getCode($k, $v)['name'];
                    $data = $this->getCalculateWeightItem($k, $v);
                }

                $result[$k] = $data;
            }

            return $result;
        }

        /**
         * 가중치 구간 검색
         *
         * @param $item
         * @param $age
         * @return mixed
         */
        public function getCalculateRangeWeightItem($item, $age)
        {
            $default = 0;

            $sql = "
                select   point
                from     tbl_weight
                where    ranges = (select   ifnull(min(ranges), $default) ranges
                                   from     tbl_weight 
                                   where    w_item = :item 
                                   and      cast(ranges as UNSIGNED) >= :age)
           ";

            $this->query($sql);
            $this->bind(":item", $item);
            $this->bind(":age", $age);

            return $this->single()['point'];
        }

        /**
         * 가중치 값 검색
         *
         * @param $item
         * @param $val
         * @return mixed
         */
        public function getCalculateWeightItem($item, $val)
        {
            $sql = "
                select   point
                from     tbl_weight
                where    w_item = :item 
                and      ranges = :val
           ";

            $this->query($sql);
            $this->bind(":item", $item);
            $this->bind(":val", $val);

            return $this->single()['point'];
        }

        public function insertMemberInfo($request)
        {

            $cellphone = $request['u_hp1'].$request['u_hp2'].$request['u_hp3'];

            $sql = "
            insert into tbl_member ( 
                name, password, birth_year, sex, location, education, job, salary, hobby, cellphone, admin_flag 
            ) values ( :
                :name, :password, :birth_year, :sex, :location, :education, :job, :salary, :hobby, :cellphone, :admin_flag
            ";

            $this->query($sql);
            $this->bind(":name", $request['u_name']);
            $this->bind(":password", password_hash($request['u_pwd1']));
            $this->bind(":birth_year", $request['u_ident1']);
            $this->bind(":sex", $request['u_ident2']);
            $this->bind(":location", $request['u_location']);
            $this->bind(":education", $request['u_edu']);
            $this->bind(":job", $request['u_work']);
            $this->bind(":salary", $request['u_salary']);
            $this->bind(":hobby", $request['u_hobby']);
            $this->bind(":cellphone", $cellphone);
            $this->bind(":admin_flag", "N");
            $this->execute();

            return $this->lastInsertId();
        }

        public function insertMemberWeight()
        {

        }


        // ----------------------------------------------------------------------------------------------------
        // -- 아래는 단축URL 관련 함수
        // ----------------------------------------------------------------------------------------------------
        /**
         * 단축 URL 조회
         *
         * @param $alias
         * @return mixed
         */
        public function alias_exist($alias)
        {
            $this->redirectUrl($alias);

            $sql = "select url from tbl_short_url where alias=:alias";
            $this->query($sql);
            $this->bind(":alias", $alias);
            $result = $this->single();

            return addURLScheme($result['url']);
        }

        public function updateHits($alias)
        {
            $sql = "update tbl_short_url set hit = hit + 1 where alias=:alias";
            $this->query($sql);
            $this->bind(":alias", $alias);
            $this->execute();

            return $this->rowCount();
        }

        /**
         * 실 URL 조회
         *
         * @param $url
         * @return null
         */
        public function url_exist($url)
        {
            $sql = "select url, alias from tbl_short_url where url = :url";
            $this->query($sql);
            $this->bind(":url", $url);
            $result = $this->single();

            if (!$result) {
                return false;
            }

            return true;
        }

        /**
         * 단축 URL 생성
         *
         * @return string
         */
        public function generate_alias_rand()
        {
            $len = 5;
            $short = "";
            $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
            $charslen = strlen($chars);

            for ($i=0; $i<$len; $i++) {
                $rnd = rand(0, $charslen);
                $short .= substr($chars, $rnd, 1);
            }

            return $short;
        }

        /**
         * 단축 URL 유효기간 체크
         *
         * @param $alias
         * @return bool
         */
        public function isExpiredDate($alias)
        {

            $sql = "select expire_dt from tbl_short_url where alias = :alias";
            $this->query($sql);
            $this->bind(":alias", $alias);
            $result = $this->single();

            if (!$result) {
                return false;
            }

            // 유효기간이 지났을 경우 삭제
            $expire_dt = $result['expire_dt'];
            if (strtotime($expire_dt) < time() && $expire_dt != "0000-00-00 00:00:00") {
                $this->deleteURL($alias);
                return true;
            }

            return false;
        }

        /**
         * URL 리다이렉트
         *
         * @param $alias
         */
        public function redirectUrl($alias)
        {
            if ($this->isExpiredDate($alias) === true) {
                header("Location: ". SITE_URL, true, 301);
                exit;
            }
        }

        /**
         * URL 등록
         *
         * @param array $info
         * @return string
         */
        public function insertURL(Array $info)
        {
            $sql = " insert into tbl_short_url ( url, alias, reg_dt, expire_dt ) values ( :url, :alias, now(),  date_add(now(), INTERVAL 30 DAY))";
            $this->query($sql);
            $this->bind(":url", $info['url']);
            $this->bind(":alias", $info['alias']);
            $this->execute();

            return $this->lastInsertId();
        }

        /**
         * 단축 URL 삭제
         *
         * @param $alias
         */
        public function deleteURL($alias)
        {
            $sql = "delete from tbl_short_url where alias = :alias";
            $this->query($sql);
            $this->bind(":alias", $alias);
            $this->execute();
        }

        /**
         * 단축 URL 삭제 (ID)
         *
         * @param $alias
         */
        public function deleteURLByID($id)
        {
            $sql = "delete from tbl_short_url where id = :id";
            $this->query($sql);
            $this->bind(":id", $id);
            $this->execute();

            return $this->rowCount();
        }

        /**
         * 단축 URL 기간 연장
         *
         * @param $admin
         * @return null
         */
        public function extendExpireURLByID($id)
        {
            $sql = "update tbl_short_url set expire_dt = date_add(expire_dt, INTERVAL 7 DAY) where id = :id";
            $this->query($sql);
            $this->bind(":id", $id);
            $this->execute();

            return $this->rowCount();
        }

        public function getAdminInfo($admin)
        {
            $sql = "select admin_id, admin_nm, admin_pwd from tbl_admin where admin_id = :admin_id";
            $this->query($sql);
            $this->bind(":admin_id", $admin['id']);
            $result = $this->single();

            if (!$result) {
                return null;
            }

            if (! $this->isValidAdminPassword($admin['pwd'], $result['admin_pwd'])) {
                return null;
            }

            return $result;
        }

        /**
         * 관리자 비밀번호 검증
         *
         * @param $pwd
         * @param $admin_pwd
         * @return bool
         */
        public function isValidAdminPassword($pwd, $admin_pwd)
        {
            return password_verify($pwd, $admin_pwd);
        }

        public function getShortenUrlList()
        {
            $sql = "select id, url, alias, hit, expire_dt, reg_dt from tbl_short_url";
            $this->query($sql);
            $result = $this->resultset($sql);

            return $result;
        }

        /**
         *
         *
         * @param $id
         * @return mixed
         */
        public function getExpireDT($id)
        {
            $sql = "select expire_dt from tbl_short_url where id = :id";
            $this->query($sql);
            $this->bind(":id", $id);
            $result = $this->single();

            return $result['expire_dt'];
        }
    }