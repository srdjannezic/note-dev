<?php 
namespace Note\Tours\Components;

use BackendAuth;
use Db;
use Cms\Classes\Page;
use Cms\Classes\ComponentBase;
use Note\Tours\Models\Tours;
use Note\Tours\Models\Destinations;
use Note\Tours\Models\Transportation;
use Note\Tours\Models\Types;
use Note\Tours\Models\Styles;

class ToursCmp extends ComponentBase
{
    public $tours;
    protected $slug;
    protected $type;
    protected $search;
    protected $limitSearch;
    protected $values;
	public $twig_get;

    public function componentDetails()
    {
        return [
            'name'        => 'Tours',
        ];
    }

    public function defineProperties()
    {
        return [
            'ToursType' => [
                'title'       => 'Tours Type',
                'type'        => 'string',
            ],
            'slug' => [
                'title'       => 'Slug',
                'default'     => '{{ :slug }}',
                'type'        => 'string',
            ],
            'name' => [
                'title'       => 'Name',
                'default'     => '{{ :name }}',
                'type'        => 'string',
            ],
            'search' => [
                'title'       => 'Search',
                'type'        => 'string',
            ],
        ];
    }




    public function onRun()
    {  
        if( $this->property('slug') ) {
            $this->slug = $this->property('slug');
        }
        if( $this->property('name') ) {
            $this->search = $this->property('name');
            $this->page['search'] = $this->search;
        }

        if(isset($_GET['destination']) || isset($_GET['destinations']) || isset($_GET['peoples']) || isset($_GET['date']) || isset($_GET['durations'])
			|| isset($_GET['transportations']) || isset($_GET['types']) || isset($_GET['styles']) || isset($_POST['price']) 
			|| isset($_POST['sort'])){ //main filter
            $this->values['destinations'] = isset($_GET['destinations']) ? $_GET['destinations'] : null;
            $this->values['numpp'] = isset($_GET['peoples']) ? $_GET['peoples'] : null;
            if(isset($_GET['durations'])){
                $this->values['durations'] = $_GET['durations'];
            }

            if(isset($_GET['transportations'])){
                $this->values['transportations'] = $_GET['transportations'];
            }

            if(isset($_GET['types'])){
                $this->values['types'] = $_GET['types'];
            }

            if(isset($_GET['numpp'])){
                $this->values['numpp'] = $_GET['numpp'];
            }

            if(isset($_GET['styles'])){
                $this->values['styles'] = $_GET['styles'];
            }

            if(isset($_POST['price'])){
                $this->values['price'] = $_GET['price'];
            }

            if(isset($_POST['sort'])){
                $this->values['sort'] = $_GET['sort'];
            }
            else{
                $this->values['sort'] = 'popular';
            }
			
            if(isset($_GET['date'])){
                $this->values['date'] = date('Y-m-d',strtotime($_GET['date']));
            }
            $this->values['sort'] = 'popular';
            //var_dump($this->values['destinations']);

            $this->tours = $this->loadFilteredTours();
            
        }
        else { 
            $this->tours = $this->page['tours'] = $this->loadTours();
        }

        //var_dump($this->property('ToursType'));
		$this->twig_get = $_GET;

		
		if($this->property('ToursType') == 'list') $this->page['last'] = $this->tours->lastPage();
        
		$this->type = $this->page['type'] = $this->property('ToursType');
        
    }

    protected function onFilterTours()
    {  
        if( $this->property('slug') ) {
            $this->slug = $this->property('slug');
        }
        if( $this->property('name') ) { //:slug
            $this->search = $this->property('name');
            $this->page['search'] = $this->search;
        }

        if( (isset($_POST['type']) && $_POST['type'] == 'filter') && !$this->search){
            if(isset($_POST['values'])){
                if(isset($_POST['values']['destinations'])){
                    $this->values['destinations'] = $_POST['values']['destinations'];
                }

                if(isset($_POST['values']['durations'])){
                    $this->values['durations'] = $_POST['values']['durations'];
                }

                if(isset($_POST['values']['transportations'])){
                    $this->values['transportations'] = $_POST['values']['transportations'];
                }

                if(isset($_POST['values']['types'])){
                    $this->values['types'] = $_POST['values']['types'];
                }

                if(isset($_POST['values']['numpp'])){
                    $this->values['numpp'] = $_POST['values']['numpp'];
                }

                if(isset($_POST['values']['styles'])){
                    $this->values['styles'] = $_POST['values']['styles'];
                }

                if(isset($_POST['values']['price'])){
                    $this->values['price'] = $_POST['values']['price'];
                }

                if(isset($_POST['sort'])){
                    $this->values['sort'] = $_POST['sort'];
                }
                else{
                    $this->values['sort'] = 'popular';
                }
            }
            //var_dump('here');
            $this->tours = $this->page['pgtours'] = $this->loadFilteredTours();
            $this->type = $this->page['pgtype'] = $this->property('ToursType');
            $this->page['last'] = $this->tours->lastPage();
        }
        else{ 
            //var_dump('expression');
            $this->tours = $this->page['pgtours'] = $this->loadTours();
            $this->type = $this->page['pgtype'] = $this->property('ToursType');
            $this->page['last'] = $this->tours->lastPage();
        } 
		$this->twig_get = $_GET;
		if(!isset($_POST['pagination'])){
			return array('last'=>$this->page['last'],'length'=>$this->tours->total());
		}
    } 



    public function allDestinations(){
        $dest = new Destinations;
        return $dest->get();
    }

    public function allTransportations(){
        $trans = new Transportation;
        return $trans->get();
    }

    public function allStyles(){
        $stylesx = new Styles; 
        $tours = new Tours;

        $styles = Db::table('note_tours_tourstyle')->groupBy('style_id')->get();
        $stylesarr = array();
        foreach ($styles as $style) {
            $stylesarr[] = Db::table('note_tours_style')->where('id',$style->style_id)->first();
        }

        return $stylesarr;
    }

    public function allTypes(){
        $type = new Types;
        return $type->get();
    }

    public function maxPrice(){
        $tours = new Tours;
        return $tours->where('price','<=',200)->orderBy('price','desc')->first()->price;
    }

    protected function onSearch(){
        $this->search = $_POST['search'];
        $this->limitSearch = $_POST['limit'];
        
        $tours = $this->loadTours();

        $array = array();

        $dests = new Destinations;
        $dests = $dests->where('name','like','%'.$this->search.'%')->get();

        return array('tours'=>$tours,'destinations'=>$dests);
    }

    private function loadFilteredTours(){

        $curpage = 1;
        if(isset($_POST['page'])){
            $curpage = $_POST['page'];
        }
        elseif(isset($_GET['page'])){
            $curpage = $_GET['page'];
        }  

        $curpage = (int)str_replace('?page=','',$curpage);

        $tours = new Tours;
        $dest = new Destinations;
		
		//var_dump($_GET['destination']);

        if(isset($_POST['values']['destinations']) or isset($_GET['destination']) or isset($_GET['destinations'])){
            $tours = $tours
                ->join('note_tours_tourdestinations','note_tours_.id','=','note_tours_tourdestinations.tour_id')
                ->join('note_tours_destination','note_tours_destination.id','=','note_tours_tourdestinations.destination_id');
        }

        if(isset($_POST['values']['transportations']) or isset($_GET['transportations'])){
            $tours = $tours
                ->join('note_tours_tourtransportation','note_tours_.id','=','note_tours_tourtransportation.tour_id')
                ->join('note_tours_transportation','note_tours_transportation.id','=','note_tours_tourtransportation.transportation_id');
        }

        if(isset($_POST['values']['types']) or isset($_GET['types'])){
            $tours = $tours
                ->join('note_tours_tourtype','note_tours_.id','=','note_tours_tourtype.tour_id')
                ->join('note_tours_type','note_tours_type.id','=','note_tours_tourtype.type_id');
        }

        if(isset($_POST['values']['styles']) or isset($_GET['styles'])){
            $tours = $tours
                ->join('note_tours_tourstyle','note_tours_.id','=','note_tours_tourstyle.tour_id')
                ->join('note_tours_style','note_tours_style.id','=','note_tours_tourstyle.style_id');
        }

        $tours = $tours->where(function($query){
            if(isset($_POST['values']['destinations']) or isset($_GET['destination']) or isset($_GET['destinations'])){
				if(isset($_GET['destinations'])) {
					$this->values['destinations'] = $_GET['destinations'];

                    if($_GET['destinations'][0] == 'all'){
                        $query = $query->orWhere('note_tours_destination.name','!=','');
                    }
                }
                if(isset($_POST['values']['destinations']) or isset($_GET['destinations'])) {
                    foreach($this->values['destinations'] as $destx){
                        $query = $query->orWhere('note_tours_destination.name',$destx);
                    }
                }
                else{
                    if(isset($_GET['destination'])){
						if($_GET['destination'] != ''){
							$query = $query->orWhere('note_tours_destination.name',$_GET['destination']);
						}
					}
                }


            }
        })->where(function($query){ //AND
            if(isset($_POST['values']['durations']) or isset($_GET['durations']) ){
				if(isset($_GET['durations'])) 
					$this->values['durations'] = $_GET['durations'];
                foreach ($this->values['durations'] as $dur) {
                    if(strpos($dur,'-') !== false){
                        $arr = explode('-', $dur);
                        $query = $query->orWhere('note_tours_.duration','>=',$arr[0]);
                        $query = $query->where('note_tours_.duration','<=',$arr[1])->where('note_tours_.duration_value','h');
					
                    }
                    else{ 
                        $query = $query->where('note_tours_.duration','>=','1');
                        $query = $query->where('note_tours_.duration_value','d');
                    }
                }
            }
        })->where(function($query){ //AND
            if(isset($_POST['values']['transportations']) or isset($_GET['transportations'])){
				if(isset($_GET['transportations'])) 
					$this->values['transportations'] = $_GET['transportations'];
                foreach ($this->values['transportations'] as $tra) {
                    $query = $query->orWhere('note_tours_transportation.name','=',$tra);
                }
            }
        })->where(function($query){ //AND
            if(isset($_POST['values']['types']) or isset($_POST['types']) or isset($_GET['types'])){
				if(isset($_GET['types'])) 
					$this->values['types'] = $_GET['types'];
                foreach ($this->values['types'] as $tra) {
                    $query = $query->orWhere('note_tours_type.name','=',$tra);
                }
            }
        })->where(function($query){ //AND
            if(isset($_POST['values']['numpp']) || isset($_GET['peoples'])){
                if(isset($_GET['peoples']) && $_GET['peoples'] != '' ){
                    $query = $query->where('note_tours_.max_people','>=',0);
                }
                elseif(isset($_POST['values']['numpp'])){
                    foreach ($this->values['numpp'] as $num) {
                        if(strpos($num,'-') !== false){
                            $arr = explode('-', $num);
                            $query = $query->orWhere('note_tours_.max_people','>=',$arr[0]);
                            $query = $query->where('note_tours_.max_people','<=',$arr[1]);
                        }
                        else{
                            $query = $query->where('note_tours_.max_people','>=',$num);
                        }


                    }
                }
				
				if(!isset($_GET['peoples'])) $query = $query->orWhere('note_tours_.group_type','LIKE','%Private%');
            }
        })->where(function($query){ //AND
            if(isset($_POST['values']['styles']) or isset($_GET['styles'])){
				if(isset($_GET['styles'])) 
					$this->values['styles'] = $_GET['styles'];
                foreach ($this->values['styles'] as $sty) {
                    $query = $query->orWhere('note_tours_style.name','=',$sty);
                }
            }
        })->where(function($query){ //AND
            if(isset($_POST['values']['price']) or isset($_GET['price'])){
				if(isset($_GET['price'])) 
					$this->values['price'] = $_GET['price'];
                foreach ($this->values['price'] as $price) {
                    if(strpos($price,'-') !== false){
                        $arr = explode('-', $price);
                        //var_dump($arr);
                        $query = $query->orWhere('note_tours_.price','>=',$arr[0]);
                        $query = $query->where('note_tours_.price','<=',$arr[1]);
                    }
                    else{
                        $query = $query->where('note_tours_.price','<=',$price);
                    }
                }
            }
        })->where(function($query){ //AND
            if(isset($_GET['date']) && !empty($_GET['date']) ){
                $date = date('Y-m-d',strtotime($_GET['date']));
				
                //$query = $query->orWhereDate('note_tours_.tour_date','>=',$date);
            }
        });

        $tours = $tours->select('note_tours_.*')->groupBy('note_tours_.id');

        //var_dump($this->values);
		//var_dump($tours);

        if($this->values['sort'] == 'duration'){
            $tours = $tours->orderBy('duration','asc')->paginate(6,$curpage);
        }
        elseif($this->values['sort'] == 'popular'){
            $tours = $tours->orderBy('sort_order','asc')->paginate(6,$curpage);
        }
        elseif($this->values['sort'] == 'abc'){
            $tours = $tours->orderBy('name','asc')->paginate(6,$curpage);
        }
        elseif($this->values['sort'] == 'price'){
            $tours = $tours->orderBy('price','asc')->paginate(6,$curpage);
        }
        else{
            $tours = $tours->orderBy('sort_order','asc')->paginate(6,$curpage);
        }
		//
        return $tours;
    }

    protected function loadTours()
    {
        
        $type = $this->property('ToursType');
        $tours = new Tours;
        $destinations = new Destinations;
        $curpage = 1;
        if(isset($_POST['page'])){
            $curpage = $_POST['page'];
        }
        elseif(isset($_GET['page'])){
            $curpage = $_GET['page'];
        }  

        $curpage = (int)str_replace('?page=','',$curpage);
        //var_dump($type);
        //get all tours for destination
        if( ($this->slug && $type != 'similar') || ($this->search) ){

            if($this->slug){
                $slug = $this->slug;
                //var_dump($slug);
                $destination = Db::table('note_tours_destination')
                                    ->where('slug',$slug)
                                    ->first();
                $tourdestinations = Db::table('note_tours_tourdestinations')
                    ->where('destination_id',$destination->id)
                    ->get();

                foreach ($tourdestinations as $td) {
                    $tours = $tours->orWhere('id',$td->tour_id); 
                }
            }

            if($this->search){    
                $tours = $tours
                ->join('note_tours_tourstyle','note_tours_.id','=','note_tours_tourstyle.tour_id')
                ->join('note_tours_style','note_tours_style.id','=','note_tours_tourstyle.style_id')
                ->join('note_tours_tourdestinations','note_tours_.id','=','note_tours_tourdestinations.tour_id')
                ->join('note_tours_destination','note_tours_destination.id','=','note_tours_tourdestinations.destination_id')
                ->where('note_tours_.name','like','%'.$this->search.'%')
                ->orWhere('note_tours_style.name','like','%'.$this->search.'%')
                ->orWhere('note_tours_destination.name','like','%'.$this->search.'%')
                //->orWhere('note_tours_.content','like','%'.$this->search.'%')
                ->orWhere('note_tours_.summary','like','%'.$this->search.'%')->select('note_tours_.*')->groupBy('note_tours_.id')->orderBy('sort_order','asc');
                if($this->limitSearch){
                    $tours = $tours->take($this->limitSearch)->get();
                }
                else{
                    $tours = $tours->paginate(6,$curpage);
                }
            }
            else
                $tours = $tours->orderBy('sort_order','asc')->take(4)->paginate(6,$curpage);   
        }
        elseif ($type == 'list') {
            $curpage = 1;
            if(isset($_POST['page'])){
                $curpage = $_POST['page'];
            }
            elseif(isset($_GET['page'])){
                $curpage = $_GET['page'];
            }  

            $curpage = (int)str_replace('?page=','',$curpage);

            $tours = $tours->orderBy('sort_order','asc')->paginate(6,$curpage);
        }
        elseif ($type == 'similar'){
            if($this->slug){
                $slug = $this->slug;
                //var_dump($slug);
                $tourfirst = Db::table('note_tours_')
                                    ->where('slug',$slug)
                                    ->first();
                $destination_ids = Db::table('note_tours_tourdestinations')
                    ->where('tour_id',$tourfirst->id)
                    ->get();

                foreach ($destination_ids as $id) {
                    $tour_ids = Db::table('note_tours_tourdestinations')
                        ->where('destination_id',$id->destination_id)
                        ->get();

                    foreach($tour_ids as $tourid){
                        $tours = $tours->orWhere('id',$tourid->tour_id)->where('id','!=',$tourfirst->id); 
                    }
                }
                $tours = $tours->orderBy('sort_order','asc')->take(4)->get();
            }
        }
        else{
            //var_dump($type);
            $trekkingtours = "";
            if($type == 'trekking'){
                 $tourtype = Db::table('note_tours_type')
                                ->where('slug','trekking')
                                ->first();

                $typeid = $tourtype->id;

                $tourtype = Db::table('note_tours_tourtype')
                                ->where('type_id',$typeid)
                                ->get();
                //var_dump($tourtype);
                 $empty = true;
                 foreach ($tourtype as $tt) {
                     //var_dump($tt->tour_id);
                     $empty = false;
                     $tours = $tours->orWhere('id',$tt->tour_id); 
                 } 
                 if (!$empty){
                	 $tours = $tours->orderBy('sort_order','asc')->take(4)->get();
				 }
            }
            elseif($type == 'nottrekking'){

                 $type = Db::table('note_tours_type')
                                ->where('slug','!=','trekking')
                                ->first();

                $typeid = $type->id;
                

                $tourtype = Db::table('note_tours_tourtype')
                                ->where('type_id',$typeid)
                                ->get();
                
                 foreach ($tourtype as $tt) {
                     //var_dump($tt->tour_id);
                     $tours = $tours->orWhere('id',$tt->tour_id); 
                     //var_dump($tours);
                 }

                $tours = $tours->orderBy('sort_order','asc')->take(4)->get(); 

            }
            else{
                $tours = $tours->orderBy('sort_order','asc')->take(4)->get();
            }
            
        }
        //var_dump($tours);
        return $tours;
    }

    protected function checkEditor()
    {
        $backendUser = BackendAuth::getUser();

        return $backendUser && $backendUser->hasAccess('rainlab.blog.access_posts');
    }
}
