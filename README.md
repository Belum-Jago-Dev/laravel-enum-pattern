# Laravel Enumeration Pattern


## Tutorial

Edit users migration seperti berikut ini :

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->enum('status', ['0', '1', '2'])->default(0)->comment('0: inactive, 1: active, 2: blocked');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};

```

setelah itu rubah file database seeder seperti berikut ini :

```php
<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::factory(10)->create();
    }
}
```

jangan lupa ya untuk factory seeder nya juga dirubah seperti berikut ini :

```bash
<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'status' => fake()->randomElement(['0', '1', '2']),
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return static
     */
    public function unverified()
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}

```

Selanjutnya, setelah kalian migrate databasenya, Kalian rubah Model user seperti berikut ini :

```php
<?php

namespace App\Models;

use App\Enum\User\CheckStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'status',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'status' => CheckStatus::class,
    ];

}

```

Setelah class enum di casting, jangan lupa untuk syntax class enum nya juga ditambahkan yaa, kalo ngga nanti ga bakal jalan dong : 

```php
<?php

namespace App\Enum\User;

enum CheckStatus: string
{
    case INACTIVE = '0';
    case ACTIVE = '1';
    case BLOCKED = '2';

    public function isInactive(): bool
    {
        return $this == self::INACTIVE;
    }

    public function isActive(): bool
    {
        return $this == self::ACTIVE;
    }

    public function isBlocked(): bool
    {
        return $this == self::BLOCKED;
    }

    public function getTextLabel(): string
    {
        return match ($this) {
            self::INACTIVE => 'Tidak Aktif',
            self::ACTIVE => 'Aktif',
            self::BLOCKED => 'Di Blokir',
        };
    }
}

```

jangan lupa buat controller untuk mengembalikan view, yang nantinya data akan di passing lewat function tersebut ya : 

```php

public function index()
{
    $users = User::all();

    return view('welcome', compact('users'));
}

```

terakhir di view kalian bisa lakukan seperti cara dibawah ini, btw gua pakai bootstrap 5 yaa : 

```php
<div class="container">
        <div class="row justify-content-center align-items-center" style="height: 100vh">
            <div class="col-12 col-md-10">
                <table class="table table-responsive table-bordered table-hover">
                    <thead>
                        <tr>
                            <th class="text-center" scope="col">#</th>
                            <th class="text-center" scope="col">Name</th>
                            <th class="text-center" scope="col">Email</th>
                            <th class="text-center" scope="col">Status</th>
                            <th class="text-center" scope="col">Created at</th>
                            <th class="text-center" scope="col">Updated at</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                        <tr>
                            <th class="text-center align-middle" scope="row">
                                {{ $loop->iteration }}
                            </th>
                            <td class="text-center align-middle">
                                {{ $user->name }}
                            </td>
                            <td class="text-center align-middle">
                                {{ $user->email }}
                            </td>
                            <td class="text-center align-middle">
                                <span @class([
                                    'badge',
                                    'bg-primary' => $user->status->isActive(),
                                    'bg-warning' => $user->status->isInactive(),
                                    'bg-danger' => $user->status->isBlocked()
                                ])>
                                    {{ $user->status->getTextLabel() }}
                                </span>
                            </td>
                            <td class="text-center align-middle">
                                {{ $user->created_at }}
                            </td>
                            <td class="text-center align-middle">
                                {{ $user->updated_at }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <th class="text center">Data Kosong</th>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

```

## Dev 
DayCod Github : <a href="https://github.com/dayCod">Follow Disini</a>

thanks guys

