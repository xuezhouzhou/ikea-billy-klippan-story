<?php
class Page{
	//每页显示多少记录
	public $num = 10;
	
	//当前页
	public $curPage = 1;
	
	//总页数
	public $totalPage;
	
	//总记录数
  public $totalNum;
    
   
 
    
	public function __construct($num,$totalNum,$curPage,$param,$url){
		
		$this->num = $num;
		
		$this->totalNum = $totalNum;
		
		$this->totalPage = ceil($this->totalNum/$this->num);
		
		$this->curPage = $curPage;
		
		if($this->curPage==null || $this->curPage <= 0){
			$this->curPage = 1;
		}
		
		if($this->curPage > $this->totalPage){
			$this->curPage = $this->totalPage;
		}
		
	
	}
    
	public function getPageBar(){
  	//总页数小于两页直接返回空
    if($this->totalNum<2) return '';
		
		$pageBar = '';
   	$pageBar .= '<ul class="pagination">';
    
		
		//上一页	
   	if($this->curPage-1 > 0){
    	$pageBar .= '<li><a href="?p='.($this->curPage-1).'"><span class="glyphicon glyphicon-chevron-left"></span>&nbsp;上页</a></li>';
   	}else{
			$pageBar .= '<li class="disabled"><a><span class="glyphicon glyphicon-chevron-left"></span>&nbsp;上页</a></li>';
   	}
		
		
		if(($this->curPage-2) > 0){
			$pageBar .= '<li><a href="?p='.($this->curPage-2).'">'.($this->curPage-2).'</a></li>';
		}	
    
		if(($this->curPage-1) > 0){
			$pageBar .= '<li><a href="?p='.($this->curPage-1).'">'.($this->curPage-1).'</a></li>';
		}	
   	
  	$pageBar .= '<li class="active"><a>'.$this->curPage.'</a></li>';
    
		if(($this->curPage+1) <= $this->totalPage){
			$pageBar .= '<li><a href="?p='.($this->curPage+1).'">'.($this->curPage+1).'</a></li>';
		}
		
		if(($this->curPage+2) <= $this->totalPage){
			$pageBar .= '<li><a href="?p='.($this->curPage+2).'">'.($this->curPage+2).'</a></li>';
		}
    
		//下一页	
  	if($this->curPage+1 <= $this->totalPage){
    	$pageBar .= '<li><a href="?p='.($this->curPage+1).'">下页<span class="glyphicon glyphicon-chevron-right"></a></li>';
		}else{
			$pageBar .= '<li class="disabled"><a href="'.$this->url.'">下页&nbsp;<span class="glyphicon glyphicon-chevron-right"></span></a></li>';
    }
    	
  	return $pageBar;
	}
}