<?php
namespace AppBundle\Utils\Service;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Aws\S3\S3Client;


class HelperService
{
	private $container;
	private $em;
	
	public function __construct(ContainerInterface $container)
	{
		$this->container = $container;
		$this->em = $container->get('doctrine')->getManager();
	}
	
	
	public function uploadToS3 ($imageData, $contentType = NULL)
	{		
		$fileName = date("YmdHis") . '_' . mt_rand() . '_smb.jpg';
		$fullFilePath = 'images/' . $fileName;
		$filteredData = substr($imageData, strpos($imageData, ",") + 1);
		$unencodedData = base64_decode($filteredData);
		$fp = fopen($fullFilePath, 'wb');
		fwrite($fp, $unencodedData);
		fclose($fp);
		chmod($fullFilePath, 0777);
		
		$bucket = $this->container->getParameter('s3_bucket_name');
		$awsAccessKey =$this->container->getParameter('aws_access_key');
		$awsSecretKey = $this->container->getParameter('aws_secret_key');
		$region = $this->container->getParameter('ap_southeast_1');
		$s3 = S3Client::factory(array(
				'region'   => $region,
				'credentials' => array(
						'key'    => $awsAccessKey,
						'secret' => $awsSecretKey,
				),
	
		));
		// 2. Create a new multipart upload and get the upload ID.
		if (!empty($contentType)) {
			$result = $s3->createMultipartUpload(
					array('Bucket' => $bucket, 'Key' => $fileName, 'StorageClass' => 'REDUCED_REDUNDANCY', 'ContentType' => $contentType, 'ACL' => 'public-read',
							'Metadata' => array()));
		} else {
			$result = $s3->createMultipartUpload(
					array('Bucket' => $bucket, 'Key' => $fileName, 'StorageClass' => 'REDUCED_REDUNDANCY', 'ACL' => 'public-read', 'Metadata' => array()));
		}
		$uploadId = $result['UploadId'];
		// 3. Upload the file in parts.
		try {
			$file = fopen($fullFilePath, 'r');
			$parts = array();
			$partNumber = 1;
			while (!feof($file)) {
				$result = $s3->uploadPart(
						array('Bucket' => $bucket, 'Key' => $fileName, 'UploadId' => $uploadId, 'PartNumber' => $partNumber, 'Body' => fread($file, 5 * 1024 * 1024)));
				$parts[] = array('PartNumber' => $partNumber++, 'ETag' => $result['ETag']);
			}
			fclose($file);
		} catch (S3Exception $e) {
			$result = $s3->abortMultipartUpload(array('Bucket' => $bucket, 'Key' => $fileName, 'UploadId' => $uploadId));
			return $result;
		}
	
		// 4. Complete multipart upload.
		$result = $s3->completeMultipartUpload(array('Bucket' => $bucket, 'Key' => $fileName, 'UploadId' => $uploadId, 'Parts' => $parts));
	
		// 		$url = $result['Location']; // s3 bucketName url
		$url = $result['Location'];
		
		unlink($fullFilePath);
		return $url;
		
		
	}
	
	/* Get minimum service amount in a center */
	public function minServiceAmount($centerId)
	{
		$minAmount = $this->em->getRepository('AppBundle:Services')->getMinServiceAmount($centerId);
		return $minAmount;
	}
}
