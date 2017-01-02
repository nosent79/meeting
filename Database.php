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

        /**
         * 회원정보 저장
         * 
         * @param $request
         * @return string
         */
        public function insertMemberInfo($request)
        {

            $sql = "
            insert into tbl_member ( 
                name, email, password, birth_year, sex, location, education, job, salary, hobby, cellphone, admin_flag 
            ) values (
                :name, :email, :password, :birth_year, :sex, :location, :education, :job, :salary, :hobby, :cellphone, 'N'
            )
            ";

            $this->query($sql);
            $this->bind(":name", $request['name']);
            $this->bind(":email", $request['email']);
            $this->bind(":password", $request['password']);
            $this->bind(":birth_year", $request['birth_year']);
            $this->bind(":sex", $request['sex']);
            $this->bind(":location", $request['location']);
            $this->bind(":education", $request['education']);
            $this->bind(":job", $request['job']);
            $this->bind(":salary", $request['salary']);
            $this->bind(":hobby", $request['hobby']);
            $this->bind(":cellphone", $request['cellphone']);
            $this->execute();

            return $this->lastInsertId();
        }

        /**
         * 더미 데이터 (회원정보)
         *
         * @return string
         */
        public function testInsertMemberInfo()
        {
//            for ($i=1; $i<=100; $i++) {
//                $sql = "
//                    INSERT INTO meeting.tbl_member (
//                        email, name, password, birth_year, location, education, job, salary, hobby, cellphone, admin_flag, reg_date, upd_date
//                    ) VALUES (
//                        'nosent_{$i}@gmail.com', '최진욱{$i}', :password, '1986', '10', '50', '16', '24', '21', '01041921325', 'N', '2016-12-28 11:45:29', '2016-12-28 11:45:29');
//                    ";
//                $this->query($sql);
//                $this->bind(":password", password_hash('password', PASSWORD_DEFAULT));
//                $this->execute();
//            }

            return "SUCCESS";
        }        
        
        /**
         * 회원별 가중치 등록
         * 
         * @param $member_id
         * @param array $weights
         */
        public function insertMemberWeight($member_id, Array $weights)
        {
            foreach($weights as $k => $v) {
                $sql = "
                insert into tbl_member_weight (
                    w_id, w_item, w_point
                ) values (
                    $member_id, '$k', '$v'
                )
                ";

                $this->query($sql);
                $this->execute();
            }
        }

        // 인기도 저장
        public function insertMemberPopular($member_id)
        {
            $sql = "
            insert into tbl_member_popular (
                p_id, p_point
            ) values (
                $member_id, 1
            )
            ";

            $this->query($sql);
            $this->execute();
        }

        public function getMemberInfo($member)
        {
            $sql = "select id, name, password from tbl_member where email = :email";
            $this->query($sql);
            $this->bind(":email", $member['email']);
            $result = $this->single();

            if (!$result) {
                return null;
            }

            if (! $this->isValidMemberPassword($member['pwd'], $result['password'])) {
                return null;
            }

            return $result;
        }

        public function isValidMemberPassword($pwd, $member_pwd)
        {
            return password_verify($pwd, $member_pwd);
        }

        public function getRecommendMatchingList()
        {
            // Condition
            // 1. 동성 제외
            // 2. 점수 높은 순
            if ($this->getMemberSex($_SESSION['m_id']) === "M") {
                $m_sex = "F";
            } else {
                $m_sex = "M";
            }

            $sql_mode = $this->isMySQL();

            $sql = "
                $sql_mode
                select   w_id
                        ,d.sender_id
                        ,d.status
                        ,a.email
                        ,a.name
                        ,a.birth_year
                        ,fnCodeNm('location', a.location) as location
                        ,fnCodeNm('education', a.education) as education
                        ,fnCodeNm('job', a.job) as job
                        ,fnCodeNm('salary', a.salary) as salary
                        ,fnCodeNm('hobby', a.hobby) as hobby
                        ,a.cellphone
                        ,p_point
                        ,sum(w_point) w_point 
                from     tbl_member a inner join 
                         tbl_member_weight b 
                on       a.id = b.w_id left join
                         tbl_member_popular c
                on       a.id = c.p_id left join
                         tbl_good_feel d
                on       a.id = d.receiver_id
                where    sex = '$m_sex'
                group by w_id 
                order by w_point desc
                limit 3;
            ";

            $this->query($sql);

            return $this->resultset($sql);
        }

        public function getMemberSex($m_id)
        {
            $sql = "select sex from tbl_member where id = :id";
            $this->query($sql);
            $this->bind(":id", $m_id);
            $result = $this->single();

            return $result['sex'];
        }

        public function increasePopular($p_id)
        {
            $sql = "update tbl_member_popular set p_point = p_point + 1 where p_id=:p_id";
            $this->query($sql);
            $this->bind(":p_id", $p_id);
            $this->execute();

            return $this->rowCount();
        }

        public function insertGoodFeel($info)
        {
            $sql = " insert into tbl_good_feel ( sender_id, receiver_id, status ) values ( :sender_id, :receiver_id, :status )";
            $this->query($sql);
            $this->bind(":sender_id", $info['sender_id']);
            $this->bind(":receiver_id", $info['receiver_id']);
            $this->bind(":status", $info['status']);
            $this->execute();

            return true;
        }

        public function updateGoodFeel($info)
        {
            $sql = " 
                update tbl_good_feel set status = :status 
                where sender_id = :sender_id 
                and receiver_id = :receiver_id
            ";

            $this->query($sql);
            $this->bind(":status", $info['status']);
            $this->bind(":sender_id", $info['sender_id']);
            $this->bind(":receiver_id", $info['receiver_id']);
            $this->execute();

            return true;
        }

        public function deleteGoodFeel($info)
        {
            $sql = "
                delete from tbl_good_feel 
                where sender_id = :sender_id 
                and receiver_id = :receiver_id
            ";

            $this->query($sql);
            $this->bind(":sender_id", $info['sender_id']);
            $this->bind(":receiver_id", $info['receiver_id']);
            $this->execute();

            return $this->rowCount();
        }

        public function searchMember($params)
        {
            // Condition
            // 1. 동성 제외
            // 2. 인기도 높은 순
            if ($this->getMemberSex($_SESSION['m_id']) === "M") {
                $m_sex = "F";
            } else {
                $m_sex = "M";
            }

            $condition = "";
            if ($params['ages'] !== "") {
                $ages = getAge($params['ages']);
                $condition .= " and birth_year <= $ages[0] and birth_year >= $ages[1]";
            }
            if ($params['education'] !== "") {
                $condition .= " and education = {$params['education']}";
            }
            if ($params['location'] !== "") {
                $condition .= " and location = {$params['location']}";
            }
            if ($params['job'] !== "") {
                $condition .= " and job = {$params['job']}";
            }
            if ($params['salary'] !== "") {
                $condition .= " and salary = {$params['salary']}";
            }

            $sql_mode = $this->isMySQL();

            $sql = "
                $sql_mode
                select  a.id
                        ,d.sender_id
                        ,d.status
                        ,a.email
                        ,a.name
                        ,a.birth_year
                        ,fnCodeNm('location', a.location) as location
                        ,fnCodeNm('education', a.education) as education
                        ,fnCodeNm('job', a.job) as job
                        ,fnCodeNm('salary', a.salary) as salary
                        ,fnCodeNm('hobby', a.hobby) as hobby
                        ,a.cellphone
                        ,p_point
                from     tbl_member a left join
                         tbl_member_popular c
                on       a.id = c.p_id left join
                         tbl_good_feel d
                on       a.id = d.receiver_id
                where    a.sex = '$m_sex'
                $condition      
                group by id 
                order by p_point desc;

            ";
            $this->query($sql);

            return $this->resultset($sql);
        }

        public function getMyPopularPoint($id)
        {
            $sql = "select p_point from tbl_member_popular where p_id = :id";

            $this->query($sql);
            $this->bind(":id", $id);
            $result = $this->single();

            return $result['p_point'];

        }

        public function getMatchingList($flag)
        {
            $sql_mode = $this->isMySQL();

            $sql = "
                $sql_mode
                SELECT a.id, 
                       a.name, 
                       a.birth_year, 
                       a.cellphone, 
                       a.email, 
                       fnCodeNm('location', a.location)   AS location, 
                       fnCodeNm('education', a.education) AS education, 
                       fnCodeNm('job', a.job)             AS job, 
                       fnCodeNm('salary', a.salary)       AS salary, 
                       fnCodeNm('hobby', a.hobby)         AS hobby, 
                       p_point 
                FROM   tbl_member a 
                       LEFT JOIN tbl_member_popular c 
                              ON a.id = c.p_id 
                WHERE  a.id IN (SELECT CASE 
                                         WHEN sender_id = :id THEN receiver_id 
                                         ELSE sender_id 
                                       end id 
                                FROM   tbl_good_feel 
                                WHERE  ( sender_id = :id 
                                          OR receiver_id = :id ) 
                                       AND status = '$flag') 
                GROUP  BY a.id                                        
            ";
            
            $this->query($sql);
            $this->bind(":id", $_SESSION['m_id']);

            return $this->resultset($sql);
        }

        public function receiveGoodFeelList($flag)
        {
            $sql_mode = $this->isMySQL();

            $sql = "
                $sql_mode
                SELECT a.id, 
                       a.name, 
                       a.birth_year, 
                       a.cellphone, 
                       a.email, 
                       Fncodenm('location', a.location)   AS location, 
                       Fncodenm('education', a.education) AS education, 
                       Fncodenm('job', a.job)             AS job, 
                       Fncodenm('salary', a.salary)       AS salary, 
                       Fncodenm('hobby', a.hobby)         AS hobby, 
                       p_point 
                FROM   tbl_member a 
                       LEFT JOIN tbl_member_popular c 
                              ON a.id = c.p_id 
                WHERE  a.id IN (SELECT sender_id 
                                FROM   tbl_good_feel 
                                WHERE  receiver_id = :id 
                                AND status = '$flag') 
                GROUP  BY a.id;
            ";

            $this->query($sql);
            $this->bind(":id", $_SESSION['m_id']);

            return $this->resultset($sql);
        }

        public function sendGoodFeelList($flag)
        {
            $sql_mode = $this->isMySQL();

            $sql = "
                $sql_mode
                SELECT a.id, 
                       a.name, 
                       a.birth_year, 
                       a.cellphone, 
                       a.email, 
                       Fncodenm('location', a.location)   AS location, 
                       Fncodenm('education', a.education) AS education, 
                       Fncodenm('job', a.job)             AS job, 
                       Fncodenm('salary', a.salary)       AS salary, 
                       Fncodenm('hobby', a.hobby)         AS hobby, 
                       p_point 
                FROM   tbl_member a 
                       LEFT JOIN tbl_member_popular c 
                              ON a.id = c.p_id 
                WHERE  a.id IN (SELECT receiver_id 
                                FROM   tbl_good_feel 
                                WHERE  sender_id = :id 
                                AND status = '$flag') 
                GROUP  BY a.id;                                
            ";

            $this->query($sql);
            $this->bind(":id", $_SESSION['m_id']);

            return $this->resultset($sql);
        }

        public function insertAssess($params)
        {
            $sql = " insert into tbl_assess ( assessor_id, target_id, point, comment ) values ( :assessor_id, :target_id, :point, :comment )";
            $this->query($sql);
            $this->bind(":assessor_id", $_SESSION['m_id']);
            $this->bind(":target_id", $params['target_id']);
            $this->bind(":point", $params['assess_point']);
            $this->bind(":comment", $params['assess_comment']);
            $this->execute();

            return $this->rowCount();
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




        public function test1()
        {
            $sql = " insert into test1 ( t1 ) values ( 'a' )";
            $this->query($sql);
            $this->execute();

            return true;
        }
        public function test2()
        {
            $sql = " insert into test2 ( t1 ) values ( 'aaaaaa' )";
            $this->query($sql);
            $this->execute();

            return true;
        }
        public function test3()
        {
            $sql = " insert into test3 ( t1 ) values ( a, b )";
            $this->query($sql);
            $this->execute();

            return true;
        }

        public function isMySQL()
        {
            MYSQL ? $mode = "SET sql_mode = '';" : $mode = "";

            return $mode;
        }
    }