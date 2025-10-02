<?php
/**
 * Home Controller
 * Handles public website homepage
 */

class HomeController extends Controller {
    public function __construct($db, $auth) {
        parent::__construct($db, $auth);
    }

    public function index() {
        // Get homepage data from database
        $carouselModel = $this->model('Carousel');
        $aboutModel = $this->model('About');
        $courseModel = $this->model('Course');
        $eventModel = $this->model('Event');
        $galleryModel = $this->model('Gallery');
        $testimonialModel = $this->model('Testimonial');

        $data = [
            'title' => APP_NAME,
            'carousel' => $carouselModel->getActive(),
            'about' => $aboutModel->getActive(),
            'courses' => $courseModel->getActive(),
            'events' => $eventModel->getUpcoming(),
            'gallery' => $galleryModel->getActive(),
            'testimonials' => $testimonialModel->getActive(),
            'school_info' => [
                'name' => SCHOOL_NAME,
                'address' => SCHOOL_ADDRESS,
                'phone' => SCHOOL_PHONE,
                'email' => SCHOOL_EMAIL,
                'website' => SCHOOL_WEBSITE
            ]
        ];

        $this->view('home/index', $data);
    }
}