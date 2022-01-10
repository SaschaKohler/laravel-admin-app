<?php

namespace Database\Factories;

use App\Models\Tool;
use Illuminate\Database\Eloquent\Factories\Factory;

class ToolFactory extends Factory
{

    protected $model = Tool::class;
    protected $counter = 0;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $tools =
            [
                'Motorsäge Stihl 260 1',
                'Motorsäge Stihl 260 2',
                'Motorsäge Husqvarna',
                'Motorsäge Stihl 193 C',
                'Akkusäge Stihl',
                'Akkuheckenschere',
                'Teleskopstangensäge',
                'Stihl Hochent.Heckensch.',
                'Laubbläser',
                'Erdbohrer',
                'Rüttelplatte',
                'Stockfräse Carlton',
                'Stockfräse Vermeer',
                'Freischneider Stihl FS 460 1',
                'Freischneider Stihl FS 460 2',
                'Freischeider Stihl FS 410',
                'Motormäher',
                'Rasentraktor Kubota',
                'Rasentraktor John Deere',
                'Rasenmäher Alko',
                'Rasenmäher Grizzly 1',
                'Rasenmäher Grizzly 2',
                'Vertikutierer Billy Goat',
                'Mini Bagger',
                'Forstkranwagen',
                'Radlader Gehl',
                'Carraro'
            ];


        $tool = $tools[$this->counter];

        $this->counter += 1;

        return [

            'title' => $tool


        ];
    }
}
