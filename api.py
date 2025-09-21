#!/usr/bin/python3.6
# general
from flask import Flask, jsonify, request
import certifi
import os
import json
from datetime import datetime, timedelta
import pymysql

#os.system('cls')


# funciones
global globaldni
globaldni = 48589394

def handle_mysql():
	#HOSTNAME = "190.210.180.106" 
	HOSTNAME = "localhost" 
	USERNAME = "ayc" 
	PASSWORD = "myd"
	DATABASE = "ayc"
	# Open database connection
	try:		
		db = pymysql.connect(HOSTNAME,USERNAME,PASSWORD,DATABASE)
		print ('Conectado a la DB')
		return db
	except Exception as e:
		print ('Error al conectar a DB: {}'.format(e))
		return 'Error'



def checkEmpleado(dni):
	
	if int(dni)==globaldni:
		dni=19012305	
	sql = """
		SELECT COUNT(*) FROM empleadosAR \
		WHERE Identificacion='%s' LIMIT 1""" % (dni)

	try:
		db = handle_mysql()
		# prepare a cursor object using cursor() method
		cursor = db.cursor()
		# Execute the SQL command
		cursor.execute(sql)
		# Fetch all the rows in a list of lists.
		results = cursor.fetchall()
		for row in results:
	   		db.close()
		   	if row[0]==0:
		   		print ('Empleado Encontrado: False')
		   		return False
		   	elif row[0]==1:
		   		print ('Empleado Encontrado: True')
		   		return True
		   	else:
		   		return row[0]
		   	"""
		      fname = row[0]
		      lname = row[1]
		      age = row[2]
		      sex = row[3]
		      income = row[4]
		      # Now print fetched result
		      print ("fname = %s,lname = %s,age = %d,sex = %s,income = %d" % \
		         (fname, lname, age, sex, income ))
		    """
	except Exception as e:
		# disconnect from server
		print ("Error: unable to fetch data. {}".format(e))
		return 'Error'

	
def extract_digits(string):
	import re
	result=re.sub('\D', '', string)
	return int(result)





def validarDNI(dni):
	try:
		

		if len(str(dni))>6 and len(str(dni))<9:
			print ('Validar DNI: True')
			return True
		else:
			print ('Validar DNI: False')
			return False

	except Exception as e:

		print ('Validar DNI: False. {}'.format(e))
		return False

def vigenciaEmpleado(dni):

	'''
	
	sql = """
		SELECT VigenciaDesde, VigenciaHasta FROM empleadosAR \
		WHERE Identificacion='%s' LIMIT 1""" % (dni)
      
	try:
		db = handle_mysql()
		# prepare a cursor object using cursor() method
		cursor = db.cursor()
	except Exception as e:
		print ("Error: unable to connect to DB: {}".format(e))
		return False

	
	if int(dni)==globaldni:
	   return True
		
	try:
	   # Execute the SQL command
	   cursor.execute(sql)
	   # Fetch all the rows in a list of lists.
	   results = cursor.fetchall()
	   db.close()
	   for row in results:	   	
	   	date_object_desde = datetime.strptime(str(row[0]).strip(), '%Y-%m-%d')
	   	date_object_hasta = datetime.strptime(str(row[1]).strip(), '%Y-%m-%d') 
	   	print (date_object_hasta)
	   	if datetime.now()<=date_object_hasta:	   		
	   		print ('Vigencia hasta: OK')
	   		if datetime.now()>=date_object_desde:
	   			print ('Vigencia desde: OK')


	   		

	   	elif datetime.now()==date_object:	   		
	   		print ('Empleado Vigente: True')
	   		return True
	   	else:
	   		
	   		print ('Empleado Vigente: False')
	   		return False

	   	"""
	   	if row[0]==0:
	   		return False
	   	elif row[0]==1:
	   		return True
	   	else:
	   		return row[0]
	   	"""
	   	"""
	      fname = row[0]
	      lname = row[1]
	      age = row[2]
	      sex = row[3]
	      income = row[4]
	      # Now print fetched result
	      print ("fname = %s,lname = %s,age = %d,sex = %s,income = %d" % \
	         (fname, lname, age, sex, income ))
	    """
	except Exception as e:
	   print ("Error: unable to fetch data: {}".format(e))
	   return False


	# disconnect from server
	db.close()
	'''


def checkDocumentacion(dni):

	if int(dni)==globaldni:
		dni=19012305

	sql = """
			SELECT E.Empresa ,
		P.Proveedor , 
		L.Nombre , 
		L.Identificacion ,
		L.CUIL , 
		CASE L.Condicion
		  WHEN 'EM' THEN 'EMPLEADO' 
		  WHEN 'AU' THEN 'AUTONOMO' 
		  ELSE L.Condicion 
		END AS Condicion , 
		L.F931 ,
		L.Poliza , 
		L.VigenciaDesde , 
		L.VigenciaHasta , 
		CASE L.SeguroDeVida 
		  WHEN 'NC' THEN 'NO CORRESPONDE'
		  ELSE L.SeguroDeVida  
		END AS SeguroDeVida , 
		CASE L.ReciboSueldo 
		  WHEN 'NC' THEN 'NO CORRESPONDE' 
		  ELSE L.ReciboSueldo 
		END AS ReciboSueldo , 
		CASE L.Repeticion 
		  WHEN 'NC' THEN 'NO CORRESPONDE' 
		  ELSE L.Repeticion  
		END AS Repeticion ,
		L.Indemnidad , 
		L.Responsable 
		FROM empleadosAR L 
		INNER JOIN proveedores P ON L.IdProveedor = P.IdProveedor 
		INNER JOIN empresas E ON P.IdEmpresa = E.IdEmpresa 
		WHERE L.Identificacion='%s'""" % (dni)
	


	try:
		# connect to database
		db = handle_mysql()
		# prepare a cursor object using cursor() method
		cursor = db.cursor()
		# Execute the SQL command
		cursor.execute(sql)
		# Fetch all the rows in a list of lists.
		results = cursor.fetchall()
		# disconnect from server
		
		
		empleado = dict()

		for row in results:


	   		if row[0]==0:
	   			empleado['error'] = 'Oops...'
	   			return False

	   		empleado['apto'] = True

	   		empleado['empresa'] = row[0]
		   	empleado['proveedor'] = str(row[1]).rstrip().lstrip()
		   	empleado['nombre'] = row[2]
		   	empleado['dni'] = row[3]
		   	empleado['vigencia'] = dict()
		   	empleado['vigencia']['desde'] = row[8]
		   	empleado['vigencia']['hasta'] = row[9]
		   	


		   	try:
		   		print ('Checking vigencia...')
	   		
		   		date_object_desde = datetime.strptime(str(row[8]).strip(), '%Y-%m-%d')
		   		date_object_hasta = datetime.strptime(str(row[9]).strip(), '%Y-%m-%d') 
		   		if datetime.now()<=date_object_hasta:
		   			print ('Vigencia hasta: OK')
		   			if datetime.now()>=date_object_desde:
		   				print ('Vigencia desde: OK')
		   				empleado['vigente'] = True
		   			else:
		   				empleado['apto'] = False
		   				empleado['vigente'] = False	   				
		   		else:
		   			empleado['vigente'] = False
		   			empleado['apto'] = False
		   		print ('Vigencia checked: {}'.format(empleado['vigente']))

		   	except Exception as e:
		   		print ('No se pudo determinar la fecha')
		   		empleado['vigente'] = False
		   		empleado['apto'] = False


	   		

		   	'''
		   	empleado['f931'] = row[6]
		   	empleado['art'] = row[7]
		   	empleado['seguroVida'] = row[10]
		   	empleado['reciboSueldo'] = row[11]
		   	empleado['noRepiticion'] = row[12]
		   	empleado['indemnidad'] = row[13]
		   	'''
		   	#empleado['vigente'] = True

		   	faltantes = []
		   	presentada = []
		   	

		   	if row[6] == 'NO' or row[6] == None:
		   		empleado['apto'] = False
		   		faltantes.append('F931')

		   	if row[7] == 'NO' or row[7] == None:
		   		empleado['apto'] = False
		   		faltantes.append('ART')

		   	if row[10] == 'NO' or row[10] == None:
		   		empleado['apto'] = False
		   		faltantes.append('Seguro de Vida')
		   	
		   	if row[11] == 'NO' or row[11] == None:
		   		empleado['apto'] = False
		   		faltantes.append('Recibo de Sueldo')
		   	
		   	if row[12] == 'NO' or row[12] == None:
		   		empleado['apto'] = False
		   		faltantes.append('No Repiticion')
		   	
		   	if row[13] == 'NO' or row[13] == None:
		   		empleado['apto'] = False
		   		faltantes.append('Indemnidad')

		   	###
		   	if row[6] == 'SI':
		   		presentada.append('F931')

		   	if row[7] == 'SI':
		   		presentada.append('ART')

		   	if row[10] == 'SI':
		   		presentada.append('Seguro de Vida')
		   	
		   	if row[11] == 'SI':
		   		presentada.append('Recibo de Sueldo')
		   	
		   	if row[12] == 'SI':
		   		presentada.append('No Repiticion')
		   	
		   	if row[13] == 'SI':
		   		presentada.append('Indemnidad')

		   	empleado['documentacion'] = dict()		   	
		   	empleado['documentacion']['faltante'] = faltantes
		   	empleado['documentacion']['presentada'] = presentada
		   	db.close()

		   	return empleado


	except Exception as e:
		print (e)
		return 'Error'


	




# API

application = Flask(__name__)

@application.route("/")
def hello():
    return "AyC API v0.1" 


@application.route('/check-status-employee', methods=['POST'])
def start():
	fulldata = dict()

	fulldata['success'] = True
	fulldata['status'] = 200 #OK
	data_error = dict()
	data_error['success'] = False	

	try:
		print ("*"*20)
		print (str(request.get_json()))
		print ("\n")


		# valida el ingreso del DNI
		try:
			nroDNI = extract_digits(request.get_json()["empleado"]["dni"])
		except Exception as e:
			print ('Oops...malformed data')
			data_error['status'] = 400 #Bad Request
			return jsonify(data_error)
		print ('Valida DNI en el request')


		# valida la forma del DNI
		if validarDNI(nroDNI)==False:
			print ('Oops...malformed data')
			data_error['status'] = 400 # Bad Request
			return jsonify(data_error)
		print ('Valida formato del DNI')

		# chequea si el nroDNI corresponde a un empleado
		result = checkEmpleado(nroDNI)

		if result==False:
			fulldata ['payload'] = dict()			
			fulldata ['payload']['nroDNI'] = nroDNI
			fulldata ['payload']['estadoEmpleado'] = 'No Encontrado'		
			return jsonify(fulldata)

		if result=='Error':
			data_error['status'] = 503 # Service Unavailable'
			return jsonify(data_error)

		
		# valida si el empleado tiene vigencia
		'''
		result = vigenciaEmpleado(nroDNI)

		if result==False:
			fulldata ['payload'] = dict()	
			fulldata ['payload']['nroDNI'] = nroDNI
			fulldata ['payload']['vigente'] = False
			return jsonify(fulldata)
		
		if result=='Error':
			data_error['status'] = '503 Service Unavailable'
			return jsonify(data_error)

		'''

		# valida Apto 
		
		print ('Chequeando si es Apto')
		
		payload = checkDocumentacion(nroDNI)


		if payload == 'Error':
			data_error['status'] = 503 # Service Unavailable
			return jsonify(data_error)

		if payload == False:
			data_error['status'] = 503 # Service Unavailable
			return jsonify(data_error)
		else:
			try:
				fulldata['payload']= dict()
				fulldata['payload']['estadoEmpleado']=""
				fulldata['payload']['empleado'] = payload				
				return jsonify(fulldata)
			except Exception as e:
				print ('Error ultimo {}'.format(e))
				data_error['status'] = 500 # Internal Error
				return jsonify(data_error)

	except Exception as e:
		print ('error {}'.format(e))
		data_error['status'] = 500 # Internal Error
		return jsonify(data_error)


if __name__ == "__main__":

	application.run(debug=True, host='0.0.0.0', port=3840)
    





    
    
    
    

