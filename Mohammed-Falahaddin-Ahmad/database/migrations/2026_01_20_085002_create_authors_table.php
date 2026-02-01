    <?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    class CreateAuthorsTable extends Migration
    {
        /**
         * Run the migrations.
         */
        public function up(): void
        {
            Schema::create('authors', function (Blueprint $table) {
                $table->id();
                $table->string('name'); // "Author Name" from form
                $table->text('biography')->nullable(); // "Biography" from form
                $table->timestamps(); // created_at, updated_at
            });
        }

        /**
         * Reverse the migrations.
         */
        public function down(): void
        {
            Schema::dropIfExists('authors');
        }
    }