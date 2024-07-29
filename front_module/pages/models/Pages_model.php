<?php (defined('BASEPATH')) OR exit('No direct script access allowed');
/**
 * AIO ADMIN
 *
 * @author      Mark Price
 * @copyright   Copyright (c) 2012
 * @license     MIT License
 * @link        http://aioadmin.com
 */

class Pages_model extends CI_Model
{	
   public function __construct(){
		parent::__construct();
	}
	
	public function getPageSectionContent($page_id)
	{
		$this->db->where('page_id', $page_id);
		$query = $this->db->get('pages_section');
		$Page=$query->result();
		//printr($Page);exit;
		$output = '';
		foreach($Page as $p){
			$output .= $p->content;
		}
		return $output;
	}

	public function getPageinfobyId($page_id)
	{
		$this->db->where('id', $page_id);
		$query = $this->db->get('pages');
		$Page=$query->row_array();
		return $Page;
	}
	public function getPageContentinfobyId($page_id)
	{
		$this->db->where('page_id', $page_id);
		$query = $this->db->get('pages_section');
		$Page=$query->row();
		return $Page;
	}
	public function getPageinfobySlug($slug)
	{
		$this->db->where('slug', $slug);
		$query = $this->db->get('pages');
		$Page=$query->row();
		return $Page;
	}
	
	public function getIdbySlug($slug)
	{
		$this->db->where('slug', $slug);
		$query = $this->db->get('pages');
		$Page=$query->row();
		return $Page->id;
	}
	
	


	public function getBanner($id){
		$this->db->select('*');
		$this->db->from("banner");
		$banner = $this->db->get()->result_array();
		return $banner;
	}

	

	public function getjob(){
		$this->db->from("job");
		$job = $this->db->get()->result_array();
		return $job;
	}

	public function getSingleJob($id){
		$this->db->from("job");
		$this->db->where("id",$id);
		$job = $this->db->get()->row_array();
		return $job;
	}

	

	public function getPortfolioWhere($id){
		$this->db->from("portfolio");
		$this->db->where("id", $id);
		$portfolio = $this->db->get()->row_array();
		return $portfolio;
	}
	

	public function getHomesliderImages($id){
		$this->db->select('*');
		$this->db->from("homeslider_images");
		$this->db->where("slider_id",$id);
		$homeslider = $this->db->get()->result();
		return $homeslider;
	}

	public function getContentByid($id)
	{
		$this->db->select('content');
		$this->db->where('id', $id);
		$query = $this->db->get('pages');
		$Page=$query->result();
		return $Page;
	}
	public function getAllMenu($url)
	{
		$this->db->select('*');
		$this->db->where('url', $url);
		$query = $this->db->get('menu');
		$Page=$query->row();
		return $Page;
	}
	public function getAllSubMenu($id)
	{
		$this->db->select('*');
		$this->db->where('parent_id', $id);
		$query = $this->db->get('menu');
		$Page=$query->result_array();
		return $Page;
	}

	public function getParentMenu($id)
	{
		$this->db->select('*');
		$this->db->where('id', $id);
		$query = $this->db->get('menu');
		$Page=$query->row_array();
		return $Page;
	}

	public function getCurrentMenuTitle($slug)
	{
		$this->db->select('*');
		$this->db->where('url', $slug);
		$query = $this->db->get('menu');
		$Page=$query->row_array();
		return $Page;
	}

	public function getGalleriesById($id)
	{
		$this->db->select('*');
		$this->db->where('gallery_id', $id);
		$query = $this->db->get('gallery_images');
		$Page=$query->result_array();
		return $Page;
	}
	public function getallgalleries($page_id){
		$this->db->from("gallery g");
		$this->db->join('gallery_images gi', 'g.id = gi.gallery_id');
		$this->db->where('g.id', $page_id);
		$gallery = $this->db->get()->result();
		return $gallery;
	}

	public function getallbanners($page_id){
		$this->db->from("banner b");
		$this->db->join('banner_images bi', 'b.id = bi.banner_id');
		$this->db->where('b.id', $page_id);
		$banner = $this->db->get()->result();
		return $banner;
	}

}
