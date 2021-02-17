<?php

namespace App\Http\Controllers\API\Attribute;

use App\Http\Requests\API\Attribute\CreateAttributeAPIRequest;
use App\Http\Requests\API\Attribute\UpdateAttributeAPIRequest;
use App\Models\Attribute\Attribute;
use App\Repositories\Attribute\AttributeRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class AttributeController
 * @package App\Http\Controllers\API\Attribute
 */

class AttributeAPIController extends AppBaseController
{
    /** @var  AttributeRepository */
    private $attributeRepository;

    public function __construct(AttributeRepository $attributeRepo)
    {
        $this->attributeRepository = $attributeRepo;
    }

    /**
     * Display a listing of the Attribute.
     * GET|HEAD /attributes
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $attributes = $this->attributeRepository->paginate();

        return $this->sendResponse($attributes, 'Attributes retrieved successfully');
    }

    // public function store(CreateAttributeAPIRequest $request)
    // {
    //     $input = $request->all();

    //     $attribute = $this->attributeRepository->create($input);

    //     return $this->sendResponse($attribute->toArray(), 'Attribute saved successfully');
    // }

    /**
     * Display the specified Attribute.
     * GET|HEAD /attributes/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Attribute $attribute */
        $attribute = $this->attributeRepository->find($id);
        if (!$attribute) {
            
            return $this->sendError('Attribute not found');
        }

        return $this->sendResponse($attribute, 'Attribute retrieved successfully');
    }


    // public function update($id, UpdateAttributeAPIRequest $request)
    // {
    //     $input = $request->all();

    //     /** @var Attribute $attribute */
    //     $attribute = $this->attributeRepository->find($id);

    //     if (empty($attribute)) {
    //         return $this->sendError('Attribute not found');
    //     }

    //     $attribute = $this->attributeRepository->update($input, $id);

    //     return $this->sendResponse($attribute->toArray(), 'Attribute updated successfully');
    // }

    // public function destroy($id)
    // {
    //     /** @var Attribute $attribute */
    //     $attribute = $this->attributeRepository->find($id);

    //     if (empty($attribute)) {
    //         return $this->sendError('Attribute not found');
    //     }

    //     $attribute->delete();

    //     return $this->sendSuccess('Attribute deleted successfully');
    // }
}
