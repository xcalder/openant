<?php
class Bbs_model extends CI_Model {
    
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    
    //精华帖
    
    public function get_very_good($limit='6'){
        
        $this->db->select('DISTINCT(posting_id)');
        $this->db->where('very_good', '1');
        
        $this->db->order_by('date_added', 'DESC');
        $this->db->limit($limit);
        
        $query = $this->db->get($this->db->dbprefix('bbs_posting'));
        
        if($query->num_rows() > 0){
            $row=array();
            $postings = $query->result_array();
            foreach ($postings as $posting) {
                $retule=$this->get_posting($posting['posting_id']);
                if(!empty($retule['title'])){
                    $row[] = $retule;
                }
            }
            
            return $row;
        }
        
        return FALSE;
    }
    
    //热门帖
    
    public function get_active($limit='6'){
        
        $this->db->select('DISTINCT(posting_id), count(posting_id) as count');
        $this->db->group_by("posting_id");
        $this->db->order_by('count', 'DESC');
        $this->db->limit($limit);
        $this->db->from($this->db->dbprefix('bbs_activity'));//查
        $query = $this->db->get();
        
        if($query->num_rows() > 0){
            $row=array();
            $postings = $query->result_array();
            foreach ($postings as $posting) {
                $retule=$this->get_posting($posting['posting_id']);
                if(!empty($retule['title'])){
                    $row[] = $retule;
                }
            }
            
            return $row;
        }
        
        return FALSE;
    }
    
    //获取帖子内容
    
    public function get_posting($posting_id){
        
        $this->db->select('bb_p.user_id, bb_p.posting_id, bb_p.is_view, bb_p.very_good, bb_p.is_top, bb_p.date_added, bpd.title, fu.nickname,fu.image , bpld.plate_id, bpld.title as plate_title, count(br.replies_id) as count, bp.label');
        $this->db->where('bb_p.posting_id', $posting_id);
        $this->db->where('bpd.language_id', isset($_SESSION['language_id']) ? $_SESSION['language_id'] : '1');
        $this->db->join('bbs_posting_description AS bpd', 'bpd.posting_id = bb_p.posting_id', 'left');
        //版块名
        
        $this->db->where('bpld.language_id', isset($_SESSION['language_id']) ? $_SESSION['language_id'] : '1');
        
        $this->db->join('bbs_plate_description AS bpld', 'bpld.plate_id = bb_p.plate_id', 'left');
        //板块标签样式
        
        $this->db->join('bbs_plate AS bp', 'bp.plate_id = bb_p.plate_id', 'left');
        
        //用户发帖人
        
        $this->db->join('user AS fu', 'fu.user_id = bb_p.user_id', 'left');
        
        
        
        //回帖数
        
        $this->db->join('bbs_replies AS br', 'br.posting_id = bb_p.posting_id', 'left');
        
        
        
        //回帖人信息
        
        $this->db->join('user as u', 'br.user_id = u.user_id', 'left');
        
        
        
        $this->db->from($this->db->dbprefix('bbs_posting') . ' AS bb_p');//查
        $query = $this->db->get();
        
        if($query->num_rows() > 0){
            $row=$query->row_array();
            
            //统计访问量
            
            $this->db->where('page', 'posting');
            
            $this->db->where('page_id', $posting_id);
            $row['access_count']=$this->db->count_all_results($this->db->dbprefix('page_access_total'));
            
            //查讨论的最后回复时间
            
            $this->db->select('u.user_id, u.image, u.nickname, ba.date_added');
            
            $this->db->where('ba.posting_id', $posting_id);
            
            $this->db->join('user AS u', 'ba.user_id = u.user_id');
            
            $this->db->order_by('ba.date_added', 'DESC');
            $this->db->from($this->db->dbprefix('bbs_activity') . ' AS ba');//查
            $query = $this->db->get();
            if($query->num_rows() > 0){
                //存在
                
                $activity=$query->row_array();
                
                $row['re_user_id']=$activity['user_id'];
                $row['re_date']=$activity['date_added'];
                $row['re_image']=$activity['image'];
                $row['re_nickname']=$activity['nickname'];
            }else{
                //不存在，用发帖时间
                
                $row['re_user_id']=$row['user_id'];
                
                $row['re_date']=$row['date_added'];
                $row['re_image']=$row['image'];
                $row['re_nickname']=$row['nickname'];
            }
            return $row;
        }
        return FALSE;
    }
}