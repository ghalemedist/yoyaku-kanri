<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithDrawings;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

class LineExport implements FromCollection, WithHeadings
{
    protected $users;

    // Accept data from the controller
    public function __construct($users)
    {
        $this->users = $users;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return $this->users;
    }

    /**
     * Define column headings.
     */
    public function headings(): array
    {
        return ["お名前", "プロフィール画像"];
    }

    /**
     * Add images to the Excel file.
     */
    public function drawings()
    {
        $drawings = [];
        $row = 2; // Start from row 2 because row 1 contains headings

        foreach ($this->users as $user) {
            if ($user['pictureUrl']) {
                $drawing = new Drawing();
                $drawing->setName('Profile Image');
                $drawing->setDescription('User Profile Image');
                $drawing->setPath($user['pictureUrl']); // Adjust path as needed
                $drawing->setHeight(50); // Adjust image size
                $drawing->setCoordinates('D' . $row); // Column "D" for images
                $drawings[] = $drawing;
            }
            $row++;
        }

        return $drawings;
    }
}
