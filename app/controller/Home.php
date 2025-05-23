<?php
use App\Core\Controller;
use App\Database\database;

class home extends Controller
{
    public function index() {
        $db= new database();
        $db->createTable();
        $data['title'] = 'home';
        $this->view('home',$data);
    }
    public function course() {
        $db= new database();
        $course = new Course();
        $categories = new category();
        
        if (isset($_GET['url'])) {
            $corse_id = ["course_id" => trim($_GET['url'],"home/course/")];
        }
        $data['categories'] = $categories->findAll("asc");
        $data['rows'] = $course->first($corse_id);
        
        $data['title'] = 'course';
        $this->view('course',$data);
    }
}