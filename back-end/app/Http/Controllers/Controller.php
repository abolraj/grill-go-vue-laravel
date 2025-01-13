<?php

namespace App\Http\Controllers;

/**
 * @OA\Info( 
 *      version="1.0.0", 
 *      title="Grill Go | Comprehensive API Documentation", 
 *      description="Welcome to the Grill Go API Documentation! Discover all our powerful API endpoints and learn how to make the most of our services. Easily integrate and elevate your development experience with detailed guides and examples." 
 * )
 * 
 * @OA\Server(
 *      url="http://localhost:8000/api",
 *      description="Server API Base URL"
 * )
 * 
 * @OA\SecurityScheme( 
 *      securityScheme="bearerAuth", 
 *      type="http", 
 *      scheme="bearer", 
 *      bearerFormat="Laravel Sanctum", 
 * )
 */

abstract class Controller
{
    //
}
