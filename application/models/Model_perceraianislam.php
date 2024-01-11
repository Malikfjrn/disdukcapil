<?php 

class Model_perceraianislam extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function getPerceraianislamData($id = null) 
	{
		if($id) {
			$sql = "SELECT * FROM tbl_perceraianislam WHERE id = ?";
			$query = $this->db->query($sql, array($id));
			return $query->row_array();
		}

		$sql = "SELECT * FROM tbl_perceraianislam ORDER BY id DESC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	public function create($data = array())
	{

		if($data) {
			$create = $this->db->insert('tbl_perceraianislam', $data);
			return ($create == true) ? true : false;
		}
	}

	public function update($data, $id)
	{
		if($data && $id) {
			$this->db->where('id', $id);
			$update = $this->db->update('tbl_perceraianislam', $data);
			return ($update == true) ? true : false;
		}
	}

	public function delete($id)
	{
		$this->db->where('id', $id);
		$delete = $this->db->delete('tbl_perceraianislam');
		return ($delete == true) ? true : false;
	}

	public function countTotalPerceraianislam	()
	{
		$sql = "SELECT * FROM tbl_perceraianislam";
		$query = $this->db->query($sql);
		return $query->num_rows();
	}

	public function countTotalPerceraianislamPerMonthCurrentYear()
	{
		$currentYear = date('Y');

		$sql = "SELECT MONTH(tanggal_perceraianislam) as month, COUNT(*) as totalPerceraianislam
				FROM tbl_perceraianislam
				WHERE YEAR(tanggal_perceraianislam) = ?
				GROUP BY MONTH(tanggal_perceraianislam)";

		$query = $this->db->query($sql, array($currentYear));
		return $query->result();
	}

	public function getTotalDataPerMonthInYear($tahun)
	{
		$this->db->select('MONTH(tanggal_perceraianislam) as bulan, COUNT(*) as total_perceraianislam');
		$this->db->from('tbl_perceraianislam');
		$this->db->where('YEAR(tanggal_perceraianislam)', $tahun);
		$this->db->group_by('bulan');
		$query = $this->db->get();
		$result = $query->result_array();

		$totalData = [];
		foreach ($result as $item) {
			$totalData[$item['bulan']] = $item['total_perceraianislam'];
		}

		// Fill in missing months with 0
		for ($i = 1; $i <= 12; $i++) {
			if (!isset($totalData[$i])) {
				$totalData[$i] = 0;
			}
		}

		ksort($totalData); // Sort by month

		return $totalData;
	}


	public function getBulanLabels($tahun)
	{
		// Initialize an array with all months
		$allMonths = range(1, 12);

		$this->db->select('MONTH(tanggal_perceraianislam) as bulan', false);
		$this->db->from('tbl_perceraianislam');
		$this->db->where('YEAR(tanggal_perceraianislam)', $tahun);
		$query = $this->db->get();
		$result = $query->result_array();

		// Extract the months from the query result
		$existingMonths = array_column($result, 'bulan');

		// Get the unique months
		$uniqueMonths = array_unique($existingMonths);

		// Merge the existing months with all months to ensure all are included
		$allMonths = array_merge($allMonths, $uniqueMonths);

		// Remove duplicates and sort the months
		$allMonths = array_unique($allMonths);
		sort($allMonths);

		$labels = array_map(function ($bulan) {
			$nama_bulan = date('F', mktime(0, 0, 0, $bulan, 1));
			return ['bulan' => $nama_bulan];
		}, $allMonths);

		return $labels;
	}



	public function getTotalDataPerYear()
	{
		$this->db->select('YEAR(tanggal_perceraianislam) as tahun, COUNT(*) as total_perceraianislam');
		$this->db->from('tbl_perceraianislam');
		$this->db->group_by('tahun');
		$query = $this->db->get();
		$result = $query->result_array();

		$totalData = [];
		foreach ($result as $item) {
			$totalData[$item['tahun']] = $item['total_perceraianislam'];
		}

		return $totalData;
	}
}