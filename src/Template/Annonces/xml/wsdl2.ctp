<?xml version="1.0" encoding="UTF-8" ?>
<definitions name='ERIC'
    targetNamespace='http://alpissime.org/annonces/wsdl'
    xmlns:tns='http://alpissime.org/annonces/wsdl'
    xmlns:xsd='http://www.w3.org/2001/XMLSchema'
    xmlns:soap='http://schemas.xmlsoap.org/wsdl/soap/'
    xmlns:soapenc='http://schemas.xmlsoap.org/soap/encoding/'
    xmlns:wsdl='http://schemas.xmlsoap.org/wsdl/'
    xmlns='http://schemas.xmlsoap.org/wsdl/'>
 
<wsdl:message name='getHelloWorldRequest'>
</wsdl:message>
<wsdl:message name='getHelloWorldResponse'>
<wsdl:part name='chaineRetour' type='xsd:string'/>
</wsdl:message>
 
<portType name='ERIC_PortType'>
    <wsdl:operation name='getHelloWorld'>
        <wsdl:input  message='tns:getHelloWorldRequest'/>
        <wsdl:output message='tns:getHelloWorldResponse'/>
    </wsdl:operation>
</portType>
 
<binding name='ERIC_Binding'  type='tns:ERIC_PortType'>
    <soap:binding style='rpc'
        transport='http://schemas.xmlsoap.org/soap/http' />
      <wsdl:operation name='getHelloWorld'>
          <soap:operation
             soapAction='getHelloWorld'/>
        <wsdl:input>
            <soap:body use='literal'/>
        </wsdl:input>
        <wsdl:output>
            <soap:body use='literal'/>
        </wsdl:output>
    </wsdl:operation>
</binding>
 
<service name='WebServiceFirst'>
    <documentation>Web Service First</documentation>
    <port name='ERIC_Port' binding='tns:ERIC_Binding'>
        <soap:address location='http://alpissime.org/annonces/wsdl'/>     
    </port>
 </service>
 
</definitions>