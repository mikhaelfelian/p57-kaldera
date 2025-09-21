<?php
/**
 * Dashboard Controller
 * 
 * Created by Mikhael Felian Waskito
 * Created at 2024-01-09
 */

namespace App\Controllers;

class Dashboard extends BaseController
{
    protected $medTransModel;
    protected $transJualModel;
    protected $transBeliModel;
    protected $transJualDetModel;
    protected $fiskalModel;
    protected $db;

    public function __construct(){
        $this->itemModel = new \App\Models\ItemModel();
        $this->transJualModel = new \App\Models\TransJualModel();
        $this->transBeliModel = new \App\Models\TransBeliModel();
        $this->transJualDetModel = new \App\Models\TransJualDetModel();
        $this->fiskalModel = new \App\Models\FiskalModel();
        $this->db = \Config\Database::connect();
    }
    
    public function index()
    {        
        // Get available years from tbl_fiskal
        $availableYears = $this->getAvailableYears();
        
		$data = [
			'title' => 'Dashboard',
			'Pengaturan' => $this->pengaturan,
			'user' => $this->ionAuth->user()->row(),
			'availableYears' => $availableYears,
			'breadcrumbs' => '
				<li class="breadcrumb-item"><a href="' . base_url() . '">Beranda</a></li>
				<li class="breadcrumb-item active">Dashboard</li>
			'
		];
		return view($this->theme->getThemePath() . '/dashboard', $data);
    }
    
    /**
     * Get available years from tbl_fiskal table
     */
    private function getAvailableYears()
    {
        $years = $this->db->table('tbl_fiskal')
            ->select('tahun')
            ->distinct()
            ->orderBy('tahun', 'DESC')
            ->get()
            ->getResult();
        
        return array_column($years, 'tahun');
    }
    
    /**
     * Get monthly sales data for the last 12 months
     */
    private function getMonthlySalesData()
    {
        $data = [];
        for ($i = 11; $i >= 0; $i--) {
            $month = date('Y-m', strtotime("-$i months"));
            $monthName = date('M Y', strtotime("-$i months"));
            
            $sales = $this->db->table('tbl_trans_jual')
                ->select('SUM(jml_gtotal) as total, COUNT(*) as count')
                ->where('status_bayar', '1')
                ->where('DATE_FORMAT(tgl_masuk, "%Y-%m")', $month)
                ->get()
                ->getRow();
            
            $data[] = [
                'month' => $monthName,
                'total' => $sales->total ?? 0,
                'count' => $sales->count ?? 0
            ];
        }
        return $data;
    }
    
    /**
     * Get daily sales data for current month
     */
    private function getDailySalesData()
    {
        $currentMonth = date('Y-m');
        $daysInMonth = date('t');
        $data = [];
        
        for ($day = 1; $day <= $daysInMonth; $day++) {
            $date = $currentMonth . '-' . str_pad($day, 2, '0', STR_PAD_LEFT);
            
            $sales = $this->db->table('tbl_trans_jual')
                ->select('SUM(jml_gtotal) as total, COUNT(*) as count')
                ->where('status_bayar', '1')
                ->where('tgl_masuk', $date)
                ->get()
                ->getRow();
            
            $data[] = [
                'day' => $day,
                'total' => $sales->total ?? 0,
                'count' => $sales->count ?? 0
            ];
        }
        return $data;
    }
    
    /**
     * Get sales by category
     */
    private function getSalesByCategory()
    {
        $query = $this->db->query("
            SELECT 
                COALESCE(mk.kategori, 'Tanpa Kategori') as kategori,
                SUM(tjd.subtotal) as total_sales,
                COUNT(tjd.id) as total_items
            FROM tbl_trans_jual_det tjd
            LEFT JOIN tbl_trans_jual tj ON tjd.id_penjualan = tj.id
            LEFT JOIN tbl_m_kategori mk ON tjd.id_kategori = mk.id
            WHERE tj.status_bayar = '1'
            GROUP BY tjd.id_kategori, mk.kategori
            ORDER BY total_sales DESC
            LIMIT 5
        ");
        
        return $query->getResult();
    }
    
    /**
     * Get top selling products
     */
    private function getTopSellingProducts($limit = 5)
    {
        $query = $this->db->query("
            SELECT 
                tjd.produk,
                SUM(tjd.jml) as total_qty,
                SUM(tjd.subtotal) as total_sales,
                COUNT(tjd.id) as transactions
            FROM tbl_trans_jual_det tjd
            LEFT JOIN tbl_trans_jual tj ON tjd.id_penjualan = tj.id
            WHERE tj.status_bayar = '1'
            GROUP BY tjd.produk
            ORDER BY total_qty DESC
            LIMIT $limit
        ");
        
        return $query->getResult();
    }
    
    /**
     * Get sales for specific month
     */
    private function getMonthSales($month)
    {
        $result = $this->db->table('tbl_trans_jual')
            ->select('SUM(jml_gtotal) as total')
            ->where('status_bayar', '1')
            ->where('DATE_FORMAT(tgl_masuk, "%Y-%m")', $month)
            ->get()
            ->getRow();
        
        return $result->total ?? 0;
    }
    
    /**
     * Get today's sales
     */
    private function getTodaySales()
    {
        $today = date('Y-m-d');
        $result = $this->db->table('tbl_trans_jual')
            ->select('SUM(jml_gtotal) as total')
            ->where('status_bayar', '1')
            ->where('tgl_masuk', $today)
            ->get()
            ->getRow();
        
        return $result->total ?? 0;
    }

    /**
     * Enhanced Features Dashboard
     * Shows all 21 implemented features from the original request
     */
    public function enhancedFeatures()
    {
        $data = [
            'title' => 'Enhanced POS System Features',
            'Pengaturan' => $this->pengaturan,
            'user' => $this->ionAuth->user()->row(),
            'breadcrumbs' => '
                <li class="breadcrumb-item"><a href="' . base_url() . '">Beranda</a></li>
                <li class="breadcrumb-item active">Enhanced Features</li>
            '
        ];

        return view($this->theme->getThemePath() . '/dashboard/enhanced_menu', $data);
    }

    /**
     * System Overview Dashboard
     * Comprehensive overview of all implemented features
     */
    public function systemOverview()
    {
        $data = [
            'title' => 'System Overview - All Features',
            'Pengaturan' => $this->pengaturan,
            'user' => $this->ionAuth->user()->row(),
            'breadcrumbs' => '
                <li class="breadcrumb-item"><a href="' . base_url() . '">Beranda</a></li>
                <li class="breadcrumb-item active">System Overview</li>
            '
        ];

        return view($this->theme->getThemePath() . '/dashboard/system_overview', $data);
    }
} 