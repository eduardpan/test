<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\Patient;

class PatientController extends Controller
{
    public function createAction(Request $request)
    {
        $doctorId = $request->request->get('doctorId');

        $em = $this->getDoctrine()->getEntityManager();
        $doctorRepository = $em->getRepository('AppBundle:Doctor');
        $patientRepository = $em->getRepository('AppBundle:Patient');
	// check valid doctor for patient
	if (empty($doctorId) || empty($doctor = $doctorRepository->selectById($doctorId))) {
            return new JsonResponse(array(
                'msg' => 'Missing doctor for patient'
            ));
	}

        $patient = new Patient();
        $patient->setName($request->request->get('patientName'));
        $patient->setDoctor($doctor);
        $doctor->addPatient($patient);
        $em->persist($patient);
        $em->flush();

        $doctorPatients = $patientRepository->selectByDoctor($doctor);

	return new JsonResponse(
            array(
                'patients' => $doctorPatients,
                'doctor' => $doctor,
                'msg' => 'Here are the patients for ' . $doctor->getName()
            ),
            Response::HTTP_CREATED
        );
    }
}
