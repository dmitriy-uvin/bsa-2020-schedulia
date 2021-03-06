#/bin/bash

gcloud run deploy schedulia-api \
	--image gcr.io/$GCP_PROJECT/schedulia-api \
	--platform managed \
	--region=$GCP_REGION \
  	--add-cloudsql-instances ${GCP_PROJECT}:${GCP_REGION}:schedulia-sql \
  	--allow-unauthenticated \
	--vpc-connector schedulia-net \
	--memory 2Gi \
	--cpu 2 \
	--command="/etc/entrypoint.sh"

gcloud run deploy schedulia-worker \
	--image gcr.io/$GCP_PROJECT/schedulia-worker \
	--platform managed \
	--region=$GCP_REGION \
  	--add-cloudsql-instances ${GCP_PROJECT}:${GCP_REGION}:schedulia-sql \
  	--allow-unauthenticated \
	--memory 1Gi \
	--vpc-connector schedulia-net \
	--command="/etc/entrypoint.sh"
