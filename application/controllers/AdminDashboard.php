<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once 'Base.php';

class AdminDashboard extends Base
{
    public function __construct()
    {
        parent::__construct();
        $this->redirectPublicUser();
        $this->load->model('AdminModel');
    }

    public function index()
    {
        redirect('AdminDashboard/newApplicant', 'refresh');
    }

    protected function getErrors(){
        if ( ($error = $this->getSessionAttr('error')) != false){
            $this->unsetSessionAttr('error');
        }

        return $error;
    }

    public function newApplicant()
    {
        $newApplication = array();

        if ($this->input->get_post('changeReadStatus') != null) {
            $this->AdminModel->updateReadStatus();
            $newApplication['success'] = "The application has been updated successfully.";
        }

        $newApplication['application'] = $this->AdminModel->getApplications();
        $newApplication['menuTitle'] = 'New Loan Application';
        $newApplication['item'] = 0;
        $newApplication['error'] = $this->getErrors();
        $this->viewLoad('admin/dashboard', $newApplication);
    }

    public function processingApplication()
    {
        $processing = array();
        $processing['application'] = $this->AdminModel->getApplications(PROCESSING_LOAN);
        $processing['menuTitle'] = 'Application in Processing';
        $processing['item'] = 1;
        $processing['error'] = $this->getErrors();
        $this->viewLoad('admin/dashboard', $processing);
    }

    public function existingLoan()
    {
        $existing = array();
        $existing['application'] = $this->AdminModel->getApplications(EXISTING_LOAN);
        $existing['status'] = 'existing';
        $existing['item'] = 2;
        $existing['error'] = $this->getErrors();
        $existing['menuTitle'] = 'Current Loan';
        $this->viewLoad('admin/dashboard', $existing);
    }

    public function declinedApplication()
    {
        $declined = array();
        $declined['application'] = $this->AdminModel->getApplications(DECLINED_LOAN);
        $declined['menuTitle'] = 'Declined Loan Queue';
        $declined['error'] = $this->getErrors();
        $declined['item'] = 3;
        $this->viewLoad('admin/dashboard', $declined);
    }

    public function loanDebt()
    {
        $debt = array();
        $debt['application'] = $this->AdminModel->getApplications(DEBT_LOAN);
        $debt['menuTitle'] = 'Loan in Debt';
        $debt['error'] = $this->getErrors();
        $debt['item'] = 4;
        $this->viewLoad('admin/dashboard', $debt);
    }

    public function loanRefunded()
    {
        $returned = array();
        $returned['application'] = $this->AdminModel->getApplications(RETURNED_LOAN);
        $returned['menuTitle'] = 'Returned Loan';
        $returned['error'] = $this->getErrors();
        $returned['item'] = 5;
        $this->viewLoad('admin/dashboard', $returned);
    }

    public function viewApplication()
    {
        $loan_application_user_id = $this->uri->segment(3);
        /*$existing_loan = !!($this->uri->segment(4));*/
        $existing_loan = 1;

        $data = array();
        if (strtolower($this->input->method()) == 'post'){
            $message = $this->AdminModel->updateApplication($loan_application_user_id);
            if ($message === true) {
                $data['success'] = 'The loan is updated successfully.';
            } else {
                $data['error'] = $message;
            }
        }

        $data['application_detail'] = $this->AdminModel->getDetailsOfApplication($loan_application_user_id, $existing_loan);
        if (!isset($data['application_detail']['transactions'])) { $data['application_detail']['transactions'] = array(); }


        $this->viewLoad('admin/application_detail', $data);
    }

    public function download(){
        $item = $this->uri->segment(3, 0);
        global $exportItem;
        $status = $exportItem[$item];

        $data = $this->AdminModel->getApplications($status, true);
        $writeSuccess = $this->AdminModel->writeCSV($data);

        if ($writeSuccess == true) {
            $file = FCPATH . "export/data.csv";

            if (file_exists($file)) {
                header('Content-Description: File Transfer');
                header('Content-Type: application/octet-stream');
                header('Content-Disposition: attachment; filename="IIT_Loan_Applications_'.time().'.csv"');
                header('Expires: 0');
                header('Cache-Control: must-revalidate');
                header('Pragma: public');
                header('Content-Length: ' . filesize($file));
                readfile($file);
                exit;
            }
        } else {
            $actionName = array('newApplicant', 'processingApplication', 'existingLoan', 'declinedApplication',
                'loanDebt', 'loanRefunded');
            $this->setSessionAttr('error', 'Sorry! Internal Server Error. Please try again later');
            redirect("AdminDashboard/{$actionName[$status]}", 'refresh');
        }
    }

    public function printApplication(){
        $application_user_id = $this->uri->segment(3, 0);
        $data = $this->AdminModel->applicationFormView($application_user_id);

        $this->load->view('print', $data);
    }

    public function loanStatistics(){
        $data = $this->AdminModel->getLoanStat();
        $data['pageType'] = 'loanStat';

        $this->viewLoad('admin/loanStatistics', $data);
    }

}