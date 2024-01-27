<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\Admin\Campaign;
use App\Models\Admin\CampForm;
use App\Models\Admin\Question;
use CodeIgniter\Config\Services;


class Questions extends BaseController
{
    public function __construct() {
        $session = Services::session();
        if ($session->get('is_admin_login') == NULL) {
            header('Location: '.base_url('auth/login'));
            exit();
        }
    }
    
    protected $helpers = ['url', 'form'];

    public function index()
    {
        $data['pg_title'] = 'Augmented QA Questions';

        $datas = new Question;
        $data['datas'] = $datas->findAll();

        return view('admin/questions/index', $data);
    }

    public function create()
    {
        $data['pg_title'] = 'Augmented QA Questions';

        $campaignModel = new Campaign();
        $data['campaigns'] = $campaignModel->where('client_id',1)->findAll();
        
        return view('admin/questions/create', $data);
    }

    public function store() {
        if (! $this->validate([
            'question' => "required",
            'note'  => 'required',
            'campaign'  => 'required'
        ])) {
            return $this->response->setStatusCode(422)->setJSON([
                'errors' => $this->validator->getErrors()
            ]);
        }

        // Create a new CampaignModel instance
        $questionModel = new Question();

        // Assuming you have form data, you can validate and save it
        $data = [
            'Question' => $this->request->getPost('question'),
            'Notes' => $this->request->getPost('note')
        ];

        $questionModel->save($data);

        $getId = $questionModel->getInsertID();

        $campforms = [];
        foreach ($this->request->getPost('campaign') as $campaign_id) {
            $campforms[] = [
                'QAQues_pid' => $getId,
                'Camp_pid' => $campaign_id
            ];
        }
        $campFormModel = new CampForm();
        $campFormModel->insertBatch($campforms);

        return $this->response->setJSON(['message' => 'Question saved successfully']);
    }

    public function edit($id)
    {
        $data['pg_title'] = 'Augmented QA Questions';

        $dataQuestion = new Question();
        $data['data'] = $dataQuestion->find($id);
        $data['id'] = $id;

        $db = \Config\Database::connect(); // Assuming you have a database connection set up
        $query = $db->table('Campaign c');
        $query->select('c.Camp_Name,c.Camp_id');
        $query->select('IF(cf.QAQues_pid IS NOT NULL, TRUE, FALSE) as Selected', false);
        $query->join('QACampForm cf', "c.Camp_id = cf.Camp_pid AND  QAQues_pid='$id'", 'left');
        $query->where('c.Client_id', 1);
        $query->orWhere('Camp_id','[ALL]');
        $data['campaigns'] = $query->get()->getResult();
        
        return view('admin/questions/edit', $data);
    }

    public function update($id) {
        if (! $this->validate([
            'question' => "required",
            'note'  => 'required',
            'campaign'  => 'required'
        ])) {
            return $this->response->setStatusCode(422)->setJSON([
                'errors' => $this->validator->getErrors()
            ]);
        }

        // Create a new CampaignModel instance
        $questionModel = new Question();
        $questionData = $questionModel->find($id);

        // Assuming you have form data, you can validate and save it
        $data = [
            'Question' => $this->request->getPost('question'),
            'Notes' => $this->request->getPost('note')
        ];

        $questionModel->update($id,$data);
        
        $getId = $questionData['QAQues_id'];

        //QACampForm
        $CampFormModel = new CampForm();
        $CampFormData = $CampFormModel->where('QAQues_pid',$id)->get()->getResult();
        
        $existing = [];
        foreach ($CampFormData as $cf) {
            $existing[] = $cf->Camp_pid;
        }

        $campaignsToDelete = array_diff($existing, $this->request->getPost('campaign'));
        foreach ($campaignsToDelete as $campaignsToDelete) {
            $CampFormModel->where('Camp_pid',$campaignsToDelete)->where('QAQues_pid',$id)->delete();
        }

         // Determine new campaigns to insert
        $campaignsToInsert = array_diff($this->request->getPost('campaign'), $existing);

        $campforms = [];
        foreach ($campaignsToInsert as $campaignsToInsert) {
            $campforms[] = [
                'QAQues_pid' => $getId,
                'Camp_pid' => $campaignsToInsert
            ];
        }
        if(count($campforms) > 0)
        {
            $campFormModel = new CampForm();
            $campFormModel->insertBatch($campforms);
        }

        return $this->response->setJSON(['message' => 'Question saved successfully']);
    }

    public function delete($id){
        // Create a new CampaignModel instance
        $questionModel = new Question();
        $questionModel->where('QAQues_id',$id)->delete();

        $CampFormModel = new CampForm();
        $CampFormModel->where('QAQues_pid',$id)->delete();

        return $this->response->setJSON(['message' => 'Question deleted successfully']);
    }
}
