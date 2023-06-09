<?php

namespace App\Exceptions;

use App\Traits\ResponseTrait;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;
use Illuminate\Http\Request;

class Handler extends ExceptionHandler
{
    use ResponseTrait;

    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];


    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->renderable(function (ValidationException $e, Request $request) {
            return $this->error('Form verilerinizi kontrol etmelisiniz', [
                "errors" => $e->validator->getMessageBag(),
                "inputs" => $request->except('password')
            ]);
        });

        $this->renderable(function (NotFoundHttpException $e, Request $request) {
            return $this->error('Islem yapmak istediginiz kayit bulunamadi', $e->getMessage());
        });

        $this->renderable(function (UnauthorizedException $e, Request $request) {
            return $this->error('Islem yapmak icin yetkili degilsiniz', $e->getMessage());
        });

        $this->renderable(function (QueryException $e, Request $request) {
            return $this->error('Sql komutunuzu kontrol etmelisiniz', [
                'message' => $e->getMessage(),
                'trace' => $e->getTrace(),
            ]);
        });

        $this->renderable(function (Throwable $e, Request $request) {
            return $this->error('Bilinmeyen Hata Firlatmasi', [
                'message' => $e->getMessage(),
                'trace' => $e->getTrace(),
                'file' => $e->getFile(),
            ]);
        });

        $this->reportable(function (Throwable $e) {
            //
        });
    }
}
